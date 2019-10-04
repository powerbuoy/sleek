<template>
	<section id="another-component">
		<h2>{{ title }}</h2>
		{{ description }}
	</section>
</template>

<style lang="scss">
	#another-component {
		background: green;
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
