<template>
	<section>
		<h2>{{ title }}</h2>
		<p>{{ description }}</p>
		<button v-on:click="hello">Click me</button>
	</section>
</template>

<style lang="scss" scoped>
	section {
		h2 {
			font-size: var(--font-size-h3);
		}
	}
</style>

<script>
	export default {
		data () {
			return {
				title: 'Hello World!',
				description: 'Good Bye World!'
			};
		},
		beforeCreate () {
			console.log('beforeCreate');
		},

		created () {
			console.log('created');
		},

		beforeMount () {
			console.log('beforeMount');
		},

		mounted () {
			console.log('mounted');
		},
		methods: {
			hello () {
				alert(this.title);
			}
		}
	};
</script>
