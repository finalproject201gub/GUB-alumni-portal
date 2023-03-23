<template>
    <div>
        <div class="card card-widget">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-circle" src="/img/user1-128x128.jpg" alt="User Image">
                    <span class="username"><a href="#">{{ post.author_name }}</a></span>
                    <span class="description">Privacy {{ post.privacy_name }} - {{ post.created_at }}</span>
                </div>
                <!-- /.user-block -->
                <div class="card-tools" v-if="Number(post.author_id) === Number(sessionData.user.id)">
                    <button type="button" class="btn btn-sm btn-primary" title="Edit"
                            @click="handleEditButtonClick">
                        <i class="far fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" title="Delete"
                            @click="handleDeleteButtonClick">
                        <i class="fas fa-trash"></i>
                    </button>
                    <!--                    <button type="button" class="btn btn-tool" data-card-widget="remove">-->
                    <!--                        <i class="fas fa-times"></i>-->
                    <!--                    </button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!--                <img class="img-fluid pad" src="/img/photo2.png" alt="Photo">-->

                <p>{{ post.content }}</p>
                <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i>
                    Share
                </button>
                <button type="button" class="btn btn-default btn-sm"><i class="far fas fa-heart"></i>
                    Like
                </button>
                <!--                <span class="float-right text-muted">127 likes - 3 comments</span>-->
            </div>
            <!-- /.card-body -->
            <!--            <div class="card-footer card-comments">-->
            <!--                <div class="card-comment">-->
            <!--                    &lt;!&ndash; User image &ndash;&gt;-->
            <!--                    <img class="img-circle img-sm" src="/img/user1-128x128.jpg" alt="User Image">-->

            <!--                    <div class="comment-text">-->
            <!--                                <span class="username">-->
            <!--                                    Maria Gonzales-->
            <!--                                    <span class="text-muted float-right">8:03 PM Today</span>-->
            <!--                                </span>&lt;!&ndash; /.username &ndash;&gt;-->
            <!--                        It is a long established fact that a reader will be distracted-->
            <!--                        by the readable content of a page when looking at its layout.-->
            <!--                    </div>-->
            <!--                    &lt;!&ndash; /.comment-text &ndash;&gt;-->
            <!--                </div>-->
            <!--            </div>-->
            <!-- /.card-footer -->
            <!--            <div class="card-footer">-->
            <!--                <form action="#" method="post">-->
            <!--                    <img class="img-fluid img-circle img-sm" src="/img/user1-128x128.jpg"-->
            <!--                         alt="Alt Text">-->
            <!--                    &lt;!&ndash; .img-push is used to add margin to elements next to floating images &ndash;&gt;-->
            <!--                    <div class="img-push">-->
            <!--                        <input type="text" class="form-control form-control-sm"-->
            <!--                               placeholder="Press enter to post comment">-->
            <!--                    </div>-->
            <!--                </form>-->
            <!--            </div>-->
            <!-- /.card-footer -->
        </div>
    </div>
</template>

<script>
export default {
    name: "SinglePost",
    props: {
        post: {
            type: Object,
            default: () => {
            }
        },
        sessionData: {
            type: Object,
            default: () => {
            }
        }
    },
    methods: {
        handleEditButtonClick() {
            this.$emit('editButtonClick', this.post);
        },
        handleDeleteButtonClick() {
            this.$modal.show('dialog', {
                title: 'Delete Post',
                text: 'Are you sure you want to delete this post?',
                buttons: [
                    {
                        title: 'Yes',
                        handler: () => {
                            this.$modal.hide('dialog');
                            this.$emit('deleteButtonClick', this.post);
                        }
                    },
                    {
                        title: 'No',
                        default: true,
                        handler: () => {
                            this.$modal.hide('dialog');
                        }
                    }
                ]
            });
        }
    }
}
</script>

<style scoped>

</style>
