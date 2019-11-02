<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload</div>

                    <div class="card-body">                   
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">

                        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="failed">
                         Something went wrong
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div id="video-form" v-if="uploading && !failed">
                            <div class="alert alert-info" v-if="!uploadingComplete">
                              Your video will soon be available at <a :href="`${$root.url.url}/videos/${uid}`" target="_blank">{{$root.url.url}}/videos/{{uid}}</a>
                            </div>
                            <div class="alert alert-success" v-if="uploadingComplete">
                              Upload complete video is now processing <a href="/videos">Go to your videos</a>.
                            </div>

                            <div class="progress">
                              <div class="progress-bar progress-bar-striped bg-info" v-bind:style="{width: fileProgress + '%'}">{{fileProgress}}%</div>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" v-model="title">
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea type="text" class="form-control" v-model="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Visibility</label>
                                <select type="text" class="form-control" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>
                            
                            <span class="badge badge-dark float-right">{{saveStatus}}</span>
                            <button class="btn btn-outline-info" @click.prevent="update">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                uid:null,
                uploading: false,
                uploadingComplete: false,
                failed: false,
                file: null,
                title: 'Untitled',
                description: null,
                visibility: 'private',
                saveStatus: null,
                fileProgress: 0
            }
        },

        methods: {
            fileInputChange() {
                this.uploading = true
                this.failed = false

                this.file = document.getElementById('video').files[0]

                this.store()
                .then(() => {
                    this.uploadVideo()
                }, () => {
                    this.failed = true
                })
            },

            store() {
                return axios.post('/videos', {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                    extention: this.file.name.split('.').pop()
                })
                .then((res) => {
                    this.uid = res.data.data.uid
                })
            },

            update () {
                this.saveStatus = 'Saving changes'
                axios.put(`/videos/${this.uid}`, {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                })
                .then((res) => {
                    this.saveStatus = 'Changes saved'
                    
                    setTimeout(() => {
                        this.saveStatus = null
                    }, 3000)
                })
                .catch((error) => {
                    this.saveStatus = 'Failed to save changes'

                })
            },

            updateProgress (e) {
                e.percent = (e.loaded / e.total) * 100
                this.fileProgress = Math.round(e.percent)
            },

            uploadVideo () {
                let form = new FormData()

                form.append('video', this.file)
                form.append('uid', this.uid)

                axios.post('/upload', form, {
                    onUploadProgress: (e) => {
                        if(e.lengthComputable) {
                            this.updateProgress(e)
                        }
                    }
                }).then(() => {
                    this.uploadingComplete = true
                }, () => {
                    this.failed = true
                })
            }
        },

        mounted() {
            window.onbeforeunload = () => {
                if (this.uploading && !this.uploadingComplete && !this.failed) {
                    return 'Are you sure you want to navigate away ?'
                }
            }
        }
    }
</script>
