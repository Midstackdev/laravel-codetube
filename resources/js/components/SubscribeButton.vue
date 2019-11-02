<template>
	<div>
		<div class="subscribe-button" v-if="subscribers !== null">
			{{subscribers}} {{'subscriber' | pluralize(subscribers)}} &nbsp; 
			<button class="btn btn-outline-danger btn-sm" type="button" v-if="canSubscribe" @click.prevent="handle">
				{{userSubscribed ? 'Unsubscribe' : 'Subscribed'}}
			</button>
		</div>
	</div>
</template>

<script>
	export default {
		data () {
			return {
				subscribers: null,
				userSubscribed: false,
				canSubscribe: false,
			}
		},

		props: {
			channelSlug: null
		},

		methods: {
			getSubscriptionStatus () {
				axios.get(`/subscription/${this.channelSlug}`)
				.then((response) => {
					this.subscribers = response.data.data.count
					this.userSubscribed = response.data.data.user_subscribed
					this.canSubscribe = response.data.data.can_subscribe
				})
			},

			handle () {
				if (this.userSubscribed) {
					this.unsubscribe()
				}
				else {
					this.subscribe()	
				}
			},

			unsubscribe () {
				this.userSubscribed = false
				this.subscribers--

				axios.delete(`/subscription/${this.channelSlug}`)
			},

			subscribe () {
				this.userSubscribed = true
				this.subscribers++

				axios.post(`/subscription/${this.channelSlug}`)
			}
		},

		mounted () {
			this.getSubscriptionStatus()
		}
	}
</script>