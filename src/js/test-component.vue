<template>
	<section id="test-component">
		<h2>{{ title }}</h2>
		{{ description }}
	</section>
</template>

<style lang="scss">
	#test-component {
		background: red;
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
		methods: {
			created () {
				console.log('Created');
			}
		}
	};
</script>
