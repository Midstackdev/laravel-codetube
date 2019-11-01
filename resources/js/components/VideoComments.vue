<template>
	<div>
		<p>{{ comments.length }} {{ 'comment' | pluralize(comments.length) }}</p>
	
		<ul class="list-unstyled">
			<li class="media" v-for="comment in comments">
				<a :href="'/channel/' + comment.channel.slug">
					<img class="mr-3 img-fluid" :src="comment.channel.image" :alt="comment.channel.slug" style="width: 45px;">
				</a>
				<div class="media-body">
					<a :href="'/channel/' + comment.channel.slug" class="mt-0 mb-1">{{comment.channel.name}}</a> {{ comment.created_at_human}}
					<p>{{ comment.body }}</p>

					<div class="media" v-for="reply in comment.replies">
						<a :href="'/channel/' + reply.channel.slug">
							<img class="mr-3 img-fluid" :src="reply.channel.image" :alt="reply.channel.slug" style="width: 45px;">
						</a>
						<div class="media-body">
							<a :href="'/channel/' + reply.channel.slug" class="mt-0 mb-1">{{reply.channel.name}}</a> {{ reply.created_at_human}}
							<p>{{ reply.body }}</p>
						</div>
					</div>
					
				</div>
			</li>
		</ul>
	</div>
</template>

<script>
	export default {
		data () {
			return {
				comments: []
			}
		},

		props: {
			videoUid: null
		},

		methods: {
			getComments () {
				axios.get(`/videos/${this.videoUid}/comments`)
					.then(response => {
						this.comments = response.data.data
					})
			}
		},

		mounted () {
			this.getComments()
		}
	}
</script>