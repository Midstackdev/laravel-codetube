<template>
	<div>
		<p>{{ comments.length }} {{ 'comment' | pluralize(comments.length) }}</p>

		<div class="video-comment clearfix" v-if="$root.url.user.authenticated">
			<textarea placeholder="Say something" class="form-control video-comment__input" v-model="body"></textarea>
			<div class="float-right">
				<button type="submit" class="btn btn-outline-secondary" @click.prevent="postComment">Post</button>
			</div>
		</div>
	
		<ul class="list-unstyled">
			<li class="media" v-for="comment in comments">
				<a :href="'/channel/' + comment.channel.slug">
					<img class="mr-3 img-fluid" :src="comment.channel.image" :alt="comment.channel.slug" style="width: 45px;">
				</a>
				<div class="media-body">
					<a :href="'/channel/' + comment.channel.slug" class="mt-0 mb-1">{{comment.channel.name}}</a> {{ comment.created_at_human}}
					<p>{{ comment.body }}</p>

					<ul class="list-inline" v-if="$root.url.user.authenticated">
						<li class="list-inline-item">
							<a href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply'}}</a>
						</li>
					</ul>

					<div class="video-comment clear" v-if="replyFormVisible === comment.id">
						<textarea placeholder="Say something" class="form-control video-comment__input" v-model="replyBody"></textarea>
						<div class="float-right">
							<button type="submit" class="btn btn-outline-secondary" @click.prevent="postReply(comment.id)">Reply</button>
						</div>
					</div>

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
				comments: [],
				body: null,
				replyBody: null,
				replyFormVisible: null,
			}
		},

		props: {
			videoUid: null
		},

		methods: {
			toggleReplyForm (commentId) {
				this.replyBody = null
				if (this.replyFormVisible === commentId) {
					this.replyFormVisible = null
					return
				}

				this.replyFormVisible = commentId
			},

			postReply (commentId) {
				axios.post(`/videos/${this.videoUid}/comments`, {
					body: this.replyBody,
					reply_id: commentId
				})
				.then(response => {
					this.comments.map((comment, index) => {

						if (comment.id === commentId) {
							this.comments[index].replies.push(response.data.data)
						}
					})

					this.replyBody = null
					this.replyFormVisible = null
				})
			},

			postComment () {
				axios.post(`/videos/${this.videoUid}/comments`, {
					body: this.body
				})
				.then(response => {
					this.comments.unshift(response.data.data)
					this.body = null
				})
			},

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