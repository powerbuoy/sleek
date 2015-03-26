<?php
class Form {
	private $name;
	private $method;
	private $action;
	private $id;
	private $classes;

	public $fields;
	public $errors;
	public $data;

	private $hasFiles;
	private $hasSubmit;
	private $hiddenFields;

	private $wrapEl;
	private $fieldsetEl;
	private $legendEl;

	private $submitTxt;
	private $errorTxt;
	private $requiredTxt;
	private $requiredSymbol;

	public function __construct ($name) {
		$this->name				= $name;
		$this->id				= str_replace('_', '-', $name) . '-form';
		$this->classes			= false;
		$this->hasFiles			= false;
		$this->hasSubmit		= false;
		$this->hiddenFields		= array();
		$this->wrapEl			= 'p';
		$this->fieldsetEl		= 'fieldset';
		$this->legendEl			= 'legend';
		$this->method			= 'post';
		$this->action			= '';
		$this->submitTxt		= 'Send';
		$this->errorTxt			= 'Please fill out this field.';
		$this->requiredTxt		= 'Required field';
		$this->requiredSymbol	= '*';

		return $this;
	}

	public function validate () {
		$this->errors = array();
		$valid = true;
		$method = $this->method == 'post' ? $_POST : $_GET;

		foreach ($this->fields as $field) {
			$value = isset($method[$field['name']]) ? $method[$field['name']] : '';

			if ($field['type'] == 'fieldset') {
				foreach ($field['fields'] as $fsField) {
					$fsValue = isset($method[$fsField['name']]) ? $method[$fsField['name']] : '';

					if (!$this->validateField($fsField, $fsValue)) {
						$valid = false;
					}
				}
			}
			elseif (!$this->validateField($field, $value)) {
				$valid = false;
			}
		}

		return $valid;
	}

	private function validateField ($f, $v) {
		$method = $this->method == 'post' ? $_POST : $_GET;

		# Captcha
		if ($f['type'] == 'captcha') {
			# Make sure it's filled out
			if (isset($method['g-recaptcha-response'])) {
				$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . 
						RECAPTCHA_SECRET . 
						'&response=' . 
						$method['g-recaptcha-response'] . 
						'&remoteip=' . 
						$_SERVER['REMOTE_ADDR'];

				# Verify with google
				$curl = curl_init();

				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_TIMEOUT, 15);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 

				$curlData = curl_exec($curl);

				curl_close($curl);

				# Make sure we received a result
				if ($curlData) {
					$json = json_decode($curlData);

					if ($json->success) {
						return true;
					}
				}
			}

			# Not filled out or other error
			$this->errors[$f['name']] = $f['error'] ? $f['error'] : $this->errorTxt;

			return false;
		}

		# If not required - always valid (TODO: untrue! fix)
		if (!$f['required']) {
			return true;
		}

		# Make sure not empty
		if (strlen($v) < 1) {
			$this->errors[$f['name']] = $f['error'] ? $f['error'] : $this->errorTxt;

			return false;
		}
		# Not empty - has pattern?
		elseif ($f['pattern']) {
			# Field should be same as other field
			if (substr($f['pattern'], 0, 2) == '==') {
				$otherField = substr($f['pattern'], 2);

				if ($v != $method[$otherField]) {
					$this->errors[$f['name']] = $f['error'] ? $f['error'] : 'This field needs to be the same as ' . $otherField . '.';

					return false;
				}
			}
			# Regexp pattern (TODO)
			else {
				return true;
			}
		}
		# Not empty - no pattern - callback function?
		elseif ($f['validation'] and function_exists($f['validation'])) {
			if ($f['validation']($v)) {
				return true;
			}
			else {
				$this->errors[$f['name']] = $f['error'] ? $f['error'] : $this->errorTxt;

				return false;
			}
		}

		return true;
	}

	# Checks if form is being submitted
	public function submit () {
		return ($this->method == 'post') ? (isset($_POST[$this->name . '_submit']) ? true : false) : (isset($_GET[$this->name . '_submit']) ? true : false);
	}

	# Returns data entered in form either pure or as template $t renders it
	public function data ($t = false) {
		return $this->method == 'post' ? $_POST : $_GET;
	}

	# Returns all errors as array
	public function errors () {
		return $this->errors;
	}

	# Returns HTML5 form based on template $t (or default if no template is set)
	public function render ($t = false) {
		$html = '';

		foreach ($this->fields as $field) {
			# Remember potential file fields
			if ($field['type'] == 'file') {
				$this->hasFiles = true;
			}

			# This field is in fact a fieldset
			if ($field['type'] == 'fieldset') {
				$html .= $this->buildFieldsetHTML($field);
			}
			# Normal field
			else {
				$html .= $this->buildFieldHTML($field);
			}
		}

		$html = '<form method="' 
				. $this->method 
				. '" action="' 
				. $this->action 
				. '"' 
				. ($this->hasFiles ? ' enctype="multipart/form-data"' : '') 
				. ' id="' 
				. $this->id 
				. '"' 
				. ($this->classes ? ' class="' . $this->classes . '"' : '') 
				. '>' 
				. $html 
				. ($this->hasSubmit ? implode('', $this->hiddenFields) : $this->buildSubmitHTML(implode('', $this->hiddenFields)))
				. '</form>';

		return $html;
	}

	private function buildFieldHTML ($field) {
		$method = $this->method == 'post' ? $_POST : $_GET;
		$html = '';

		if ($field['type'] != 'hidden' and $field['type'] != 'html' and $field['type'] != 'captcha') {
			$html .= '<' . $this->wrapEl;
			$html .= $field['class'] ? ' class="' . $field['class'] . '">' : '>';
		}

		# Label
		$requiredTxt = ($field['required'] and $this->requiredTxt !== false) ? ' <abbr title="' . $this->requiredTxt . '">' . $this->requiredSymbol . '</abbr>' : '';

		if ($field['label']) {
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . $requiredTxt . '</label>';
		}
		else {
			$label = '';
		}

		# Required?
		$required = $field['required'] ? ' required' : '';

		# Pattern (note we have custom patterns in this lib - ignore those)
		$pattern = ($field['pattern'] && substr($field['pattern'], 0, 2) != '==') ? ' pattern="' . $field['pattern'] . '"' : '';

		# ID
		$id = ' id="' . $field['id'] . '"';

		# Placeholder
		$placeholder = $field['placeholder'] ? ' placeholder="' . htmlspecialchars($field['placeholder']) . '"' : '';

		# Checked
		$checked = $field['checked'] ? ' checked' : '';

		# Readonly
		$readonly = $field['readonly'] ? ' readonly' : '';

		# Disabled
		$disabled = $field['disabled'] ? ' disabled' : '';

		# Min
		$min = ($field['min'] !== false) ? ' min="' . $field['min'] . '"' : '';

		# Max
		$max = ($field['max'] !== false) ? ' max="' . $field['max'] . '"' : '';

		# Step
		$step = ($field['step'] !== false) ? ' step="' . $field['step'] . '"' : '';

		# Other attributes
		$attributes = '';

		if (count($field['attributes'])) {
			foreach ($field['attributes'] as $ak => $av) {
				$attributes .= " $ak=\"$av\"";
			}
		}

		# Build field
		switch ($field['type']) {
			# Textarea
			case 'textarea' :
				$html .= $label . '<textarea name="' . $field['name'] . '" rows="10" cols="60"' . $id . $placeholder . $required . $pattern . $readonly . $disabled . $attributes . '>' . $field['value'] . '</textarea>';

				break;

			# Radio buttons
			case 'radio' :
				$html .= '<input type="radio" name="' . $field['name'] . '" value="' . $field['value'] . '"' . $id . $checked . $readonly . $disabled . $attributes . '> ' . $label;

				break;

			# Checkboxes
			case 'checkbox' : 
				$html .= '<input type="checkbox" name="' . $field['name'] . '" value="' . $field['value'] . '"' . $id . $checked . $readonly . $disabled . $attributes . '> ' . $label;

				break;

			# Select elements
			case 'select' : 
				$html .= $label . '<select name="' . $field['name'] . '"' . $id . $readonly . $disabled . $attributes . '>';

				foreach ($field['options'] as $k => $v) {
					$selected = (isset($method[$field['name']]) and $method[$field['name']] == $v) ? ' selected' : '';
					$html .= '<option value="' . $k . '"' . $selected . '>' . $v . '</option>';
				}

				$html .= '</select>';

				break;

			# Submit button
			case 'submit' : 
				$html .= '<input type="hidden" name="' . $this->name . '_submit" value="1">';
				$html .= '<input type="submit"' . ($field['value'] ? ' value="' . $field['value'] . '"' : '') . $attributes . '>';

				break;

			# Hidden
			case 'hidden' : 
				$html .= '<input type="' . $field['type'] . '" name="' . $field['name'] . '"' . $id . $pattern . $readonly . $disabled . $attributes . ' value="' . $field['value'] . '">';

				break;

			# Arbitrary HTML
			case 'html' : 
				$html .= $field['value'];

				break;

			case 'captcha' : 
				$html .= '<div class="captcha-wrap"><div class="captcha"></div>' . 
						(isset($this->errors[$field['name']]) ? 
							'<strong class="error">' . $this->errors[$field['name']] . '</strong>' : 
							''
						) . '</div>';

				break;

			# Other input types
			default : 
				$html .= $label . '<input type="' . $field['type'] . '" name="' . $field['name'] . '"' . $id . $placeholder . $min . $max . $step . $required . $pattern . $readonly . $disabled . $attributes . ' value="' . $field['value'] . '">';

				break;
		}

		# Description
		$html .= $field['description'] ? '<small>' . $field['description'] . '</small>' : '';

		# Error?
		$html .= (isset($this->errors[$field['name']]) and $field['type'] != 'captcha') ? '<strong class="error">' . $this->errors[$field['name']] . '</strong>' : '';

		if ($field['type'] != 'hidden' and $field['type'] != 'html' and $field['type'] != 'captcha') {
			$html .= '</' . $this->wrapEl . '>';
		}

		# Remember if form has files / submit button
		if ($field['type'] == 'file') {
			$this->hasFiles = true;
		}

		if ($field['type'] == 'submit') {
			$this->hasSubmit = true;
		}

		# Store the hidden fields for later - they will be added to the last wrapper
		if ($field['type'] == 'hidden') {
			$this->hiddenFields[] = $html;

			return '';
		}

		return $html;
	}

	private function buildFieldsetHTML ($field) {
		$html = '<' . $this->fieldsetEl . '';
		$html .= $field['class'] ? ' class="' . $field['class'] . '">' : '>';

		if ($field['legend']) {
			$html .= '<' . $this->legendEl . '>' . htmlspecialchars($field['legend']) . '</' . $this->legendEl . '>';
		}

		# Render the fieldset's fields
		foreach ($field['fields'] as $fsField) {
			$html .= $this->buildFieldHTML($fsField);
		}

		$html .= '</' . $this->fieldsetEl . '>';

		return $html;
	}

	private function buildSubmitHTML ($hf = false) {
		$html = '<' . $this->wrapEl . ' class="submit">';
		$html .= $hf ? $hf : '';
		$html .= '<input type="hidden" name="' . $this->name . '_submit" value="1">';
		$html .= '<input type="submit" value="' . $this->submitTxt . '">';
		$html .= '</' . $this->wrapEl . '>';

		return $html;
	}

	# Cleans up and sets all fields
	public function addFields ($fields) {
		foreach ($fields as $field) {
			if (isset($field['fields'])) {
				$fsFields = array();

				foreach ($field['fields'] as $fsField) {
					$fsFields[] = $this->completeField($fsField);
				}

				$field['fields'] = $fsFields;
			}

			$this->fields[] = $this->completeField($field);
		}

		return $this;
	}

	private function completeField ($f) {
		static $i = 0;

		$method = $this->method == 'post' ? $_POST : $_GET;
		$value = isset($method[$f['name']]) ? $method[$f['name']] : '';

		# If form has been submitted - set checked based on POST/GET
		if ($this->submit() and isset($f['value'])) {
			# Field as part of an array of fields
			if (strpos($f['name'], '[]') !== false) {
				$newName = substr($f['name'], 0, -2);
				$checked = false;

				if (isset($method[$newName])) {
					foreach ($method[$newName] as $ff) {
						if ($ff == $f['value']) {
							$checked = true;
						}
					}
				}
			}
			# Normal field
			else {
				$checked = (isset($method[$f['name']]) and $method[$f['name']] == $f['value']) ? true : false;
			}
		}
		# If not - set checked based on whether it was set by user
		else {
			$checked = isset($f['checked']) ? true : false;
		}

		return array(
			'name'			=> $f['name'], 
			'id'			=> $this->id . '-' . $f['name'] . $i++, 
			'type'			=> isset($f['type']) ? $f['type'] : 'text', 
			'value'			=> isset($f['value']) ? $f['value'] : $value, 
			'label'			=> isset($f['label']) ? $f['label'] : false, 
			'options'		=> isset($f['options']) ? $f['options'] : false, 
			'fields'		=> isset($f['fields']) ? $f['fields'] : array(), 
			'error'			=> isset($f['error']) ? $f['error'] : false, 
			'legend'		=> isset($f['legend']) ? $f['legend'] : false, 
			'placeholder'	=> isset($f['placeholder']) ? $f['placeholder'] : false, 
			'required'		=> isset($f['required']) ? $f['required'] : false, 
			'pattern'		=> isset($f['pattern']) ? $f['pattern'] : false, 
			'class'			=> isset($f['class']) ? $f['class'] : false, 
			'checked'		=> $checked, 
			'readonly'		=> isset($f['readonly']) ? $f['readonly'] : false, 
			'disabled'		=> isset($f['disabled']) ? $f['disabled'] : false, 
			'description'	=> isset($f['description']) ? $f['description'] : false, 
			'min'			=> isset($f['min']) ? $f['min'] : false, 
			'max'			=> isset($f['max']) ? $f['max'] : false, 
			'step'			=> isset($f['step']) ? $f['step'] : false, 
			'attributes'	=> isset($f['attributes']) ? $f['attributes'] : array(), 
			'validation'	=> isset($f['validation']) ? $f['validation'] : false
		);
	}

	# Simple setters/getters
	public function method ($v = false) {
		if ($v !== false) {
			$this->method = $v;

			return $this;
		}

		return $this->method;
	}

	public function action ($v = false) {
		if ($v !== false) {
			$this->action = $v;

			return $this;
		}

		return $this->action;
	}

	public function classes ($v = false) {
		if ($v !== false) {
			$this->classes = $v;

			return $this;
		}

		return $this->classes;
	}

	public function wrapEl ($v = false) {
		if ($v !== false) {
			$this->wrapEl = $v;

			return $this;
		}

		return $this->wrapEl;
	}

	public function fieldsetEl ($v = false) {
		if ($v !== false) {
			$this->fieldsetEl = $v;

			return $this;
		}

		return $this->fieldsetEl;
	}

	public function legendEl ($v = false) {
		if ($v !== false) {
			$this->legendEl = $v;

			return $this;
		}

		return $this->legendEl;
	}

	public function submitTxt ($v = false) {
		if ($v !== false) {
			$this->submitTxt = $v;

			return $this;
		}

		return $this->submitTxt;
	}

	public function errorTxt ($v = false) {
		if ($v !== false) {
			$this->errorTxt = $v;

			return $this;
		}

		return $this->errorTxt;
	}

	public function requiredTxt ($v = false) {
		if ($v !== false) {
			$this->requiredTxt = $v;

			return $this;
		}

		return $this->requiredTxt;
	}

	public function requiredSymbol ($v = false) {
		if ($v !== false) {
			$this->requiredSymbol = $v;

			return $this;
		}

		return $this->requiredSymbol;
	}
}
