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
		--h2-size: var(--h3-size);

		ul {
			margin-left: 0;
			list-style: none;

			li {
				margin: 0 0 var(--spacing-medium);

				&.done {
					text-decoration: line-through;
				}
			}
		}

		form p {
			--form-field-border-radius: var(--button-border-radius);
			--form-field-padding-horizontal: var(--button-padding-horizontal);

			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;

			input {
				flex: 1;
				margin-right: var(--spacing-medium);
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
