<template>
	<section>
		<h2>Todo</h2>
		<ul>
			<li v-for="todo in todos" v-bind:class="{done: todo.done}">
				<label>
					<input type="checkbox" v-model="todo.done"> {{ todo.title }}
				</label>
			</li>
		</ul>
		<form v-on:submit.prevent="addTodo()">
			<p>
				<input type="text" placeholder="I need to..." v-model="newTodo">
				<button v-bind:disabled="!canAdd">Add todo</button>
			</p>
		</form>
	</section>
</template>

<style lang="scss" scoped>
	section {
		h2 {
			font-size: var(--font-size-h3);
		}

		ul {
			margin-left: 0;
			list-style: none;

			li {
				margin: 0 0 var(--spacing-default);

				&.done {
					text-decoration: line-through;
				}
			}
		}

		form p {
			--border-radius-form-field: var(--border-radius-button);
			--spacing-form-field-horizontal: var(--spacing-button-horizontal);

			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;

			input {
				flex: 1;
				margin-right: var(--spacing-default);
			}

			button {
				white-space: nowrap;
			}
		}
	}
</style>

<script>
	export default {
		data () {
			return {
				newTodo: null,
				todos: [
					{
						title: 'Read up on Sleek',
						done: true
					},
					{
						title: 'Download and install it',
						done: false
					},
					{
						title: 'Build something awesome',
						done: false
					}
				]
			};
		},
		methods: {
			addTodo () {
				if (this.canAdd) {
					this.todos.push({
						title: this.newTodo,
						done: false
					});

					this.newTodo = null;
				}
			}
		},
		computed: {
			canAdd () {
				return this.newTodo && this.newTodo.length ? true : false;
			}
		}
	};
</script>
