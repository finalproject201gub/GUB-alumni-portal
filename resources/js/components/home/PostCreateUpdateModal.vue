<template>
    <div>
        <div class="card card-widget">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-circle" src="/img/user1-128x128.jpg" alt="User Image">
                    <span class="username"><a href="#">{{ sessionData.user.name }}</a></span>
                    <span class="description" style="height: 20px;">
                        <Select2
                        :options="privacyOptions"
                        v-model="formData.privacy_id"
                        disabled
                    >
                    </Select2>
                    </span>
                </div>
                <!-- /.user-block -->
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" @click="handleXButtonClick">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <textarea placeholder="Whats Your mind?" class="form-control" v-model="formData.content" cols="30"
                          rows="10"></textarea>

            </div>
            <!-- /.card-body -->
            <!-- /.card-footer -->
            <div class="card-footer">
                <!-- post button -->
                <button type="button" :class="[this.formData.id ? 'btn-success' : 'btn-primary','form-control btn ']"
                        @click="handleModalSubmitButtonClick">
                        {{ !this.formData.id ? 'Post' : 'Update' }}

                        <span v-if="isSubmitting" class="spinner-border spinner-border-sm" role="status"
                              aria-hidden="true"></span>

                </button>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</template>

<script>
export default {
    name: 'PostCreateUpdateModal',
    props: {
        sessionData: {
            type: Object,
            default: () => {
            }
        },
        editData: {
            type: Object,
            default: () => {
            }
        }
    },
    data() {
        return {
            privacyOptions: [
                {
                    id: 1,
                    text: 'Public'
                },
                // {
                //     id: 2,
                //     text: 'Friends'
                // },
                // {
                //     id: 3,
                //     text: 'Only Me'
                // },
            ],
            formData: {
                content: '',
                privacy_id: 1
            },
            isSubmitting: false,
        }
    },
    methods: {
        addPost: async function () {
            this.isSubmitting = true;
            try {
                await axios.post('/api/v1/posts/store', this.formData);
                this.$toast.success("Post Created Successfully");
                this.$emit('postCreated');

            } catch (error) {
                console.log(error);
            }
            this.isSubmitting = false;
        },
        updatePost: async function () {
            this.isSubmitting = true;
            try {
                await axios.put(`/api/v1/posts/${this.formData.id}`, this.formData);
                this.$toast.success("Post Updated Successfully");
                this.$emit('postUpdated');

            } catch (error) {
                console.log(error);
            }
            this.isSubmitting = false;
        },
        handleModalSubmitButtonClick: function () {
            if (!this.validate()) {
                return;
            }
            if (this.formData.id) {
                this.updatePost();
                return;
            }
            this.addPost();
        },
        handleXButtonClick: function () {
            this.$emit('closeModal');
        },
        validate: function () {
            if (this.formData.content === '') {
                this.$toast.error("Post Content is required");
                return false;
            }
            return true;
        }
    },
    mounted() {
        if (this.editData && this.editData.id) {
            this.formData = this.editData;
        }
    }
}
</script>

<style>

</style>
