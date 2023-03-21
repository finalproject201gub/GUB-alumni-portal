<template>
    <div>
        <!-- <div slot="top-right">
            <button class="btn btn-secondary btn-sm" @click="$modal.hide('addPostModal')">
                <i class="fa fa-x"></i>
            </button>
        </div>
        <div class="modal-header">
            <h5 class="modal-title">Add Post</h5>
        </div>
        <div class="modal-body">
            <textarea class="form-control" v-model="content" name="content" id="" cols="30" rows="10"></textarea>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="handleModalCloseButtonClick">Close</button>
            <button type="button" class="btn btn-primary" @click="handleModalSubmitButtonClick">Save changes</button>
        </div> -->

        <div class="card card-widget">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-circle" src="/img/user1-128x128.jpg" alt="User Image">
                    <span class="username"><a href="#">Mohammad Shah Alam</a></span>
                    <span class="description" style="height: 20px;">
                        <Select2 :options="privacyOptions" v-model="formData.privacy_id"></Select2>
                    </span>
                </div>
                <!-- /.user-block -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <textarea placeholder="Whats Your mind?" class="form-control" v-model="formData.content" cols="30" rows="10"></textarea>

            </div>
            <!-- /.card-body -->
            <!-- /.card-footer -->
            <div class="card-footer">
                <!-- post button -->
                <button type="button" class="form-control btn btn-primary"
                    @click="handleModalSubmitButtonClick">Post</button>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</template>

<script>
    // import Select2 from 'v-select2-component';
    export default {
        name: 'AddPostModal',
        // components: {Select2},
        data() {
            return {
                privacyOptions: [{
                        id: 1,
                        text: 'Public'
                    },
                    {
                        id: 2,
                        text: 'Friends'
                    },
                    {
                        id: 3,
                        text: 'Only Me'
                    },
                ],
                formData: {
                    content: '',
                    privacy_id: 1
                },
            }
        },
        methods: {
            addPost: async function() {
                try {
                    const {
                        data: {
                            data
                        }
                    } = await axios.post('/api/v1/posts/store', this.formData);
                    this.$toast.success("Post Created Successfully");
                    this.$emit('postCreated', data);

                } catch (error) {
                    console.log(error);
                }
            },
            handleModalCloseButtonClick: function() {
                this.$modal.hide('addPostModal');
            },
            handleModalSubmitButtonClick: function() {
                this.addPost();
            }
        }
    }
</script>

<style>

</style>
