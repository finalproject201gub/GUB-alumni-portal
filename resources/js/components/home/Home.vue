<template>
    <div>
        <div class="row m-3">
            <div class="user-block col-md-1 col-2">
                <img class="img-circle" style="height:  60px; width: 60px; z-index: 2"
                     src="img/user1-128x128.jpg" alt="User Image">
            </div>
            <div class="col-md-11 col-10">
                <input type="text" class="form-control status-box" name="" id="" placeholder="What's on your mind?"
                       @click="showPostCreateUpdateModal">
            </div>
        </div>
        <div class="row">
            <Posts>
                <SinglePost
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                    :sessionData="sessionData"
                    @editButtonClick="editPost"
                    @deleteButtonClick="deletePost"
                />
            </Posts>
            <!-- /.col -->
            <!--            <div class="col-md-12">-->
            <!--                &lt;!&ndash; Box Comment &ndash;&gt;-->
            <!--                <div class="card card-widget">-->
            <!--                    <div class="card-header">-->
            <!--                        <div class="user-block">-->
            <!--                            <img class="img-circle" src="/img/user1-128x128.jpg" alt="User Image">-->
            <!--                            <span class="username"><a href="#">Jonathan Burke Jr.</a></span>-->
            <!--                            <span class="description">Shared publicly - 7:30 PM Today</span>-->
            <!--                        </div>-->
            <!--                        &lt;!&ndash; /.user-block &ndash;&gt;-->
            <!--                        <div class="card-tools">-->
            <!--                            <button type="button" class="btn btn-tool" title="Mark as read">-->
            <!--                                <i class="far fa-circle"></i>-->
            <!--                            </button>-->
            <!--                            <button type="button" class="btn btn-tool" data-card-widget="collapse">-->
            <!--                                <i class="fas fa-minus"></i>-->
            <!--                            </button>-->
            <!--                            <button type="button" class="btn btn-tool" data-card-widget="remove">-->
            <!--                                <i class="fas fa-times"></i>-->
            <!--                            </button>-->
            <!--                        </div>-->
            <!--                        &lt;!&ndash; /.card-tools &ndash;&gt;-->
            <!--                    </div>-->
            <!--                    &lt;!&ndash; /.card-header &ndash;&gt;-->
            <!--                    <div class="card-body">-->
            <!--                        &lt;!&ndash; post text &ndash;&gt;-->
            <!--                        <p>Far far away, behind the word mountains, far from the-->
            <!--                            countries Vokalia and Consonantia, there live the blind-->
            <!--                            texts. Separated they live in Bookmarksgrove right at</p>-->

            <!--                        <p>the coast of the Semantics, a large language ocean.-->
            <!--                            A small river named Duden flows by their place and supplies-->
            <!--                            it with the necessary regelialia. It is a paradisematic-->
            <!--                            country, in which roasted parts of sentences fly into-->
            <!--                            your mouth.</p>-->

            <!--                        &lt;!&ndash; Attachment &ndash;&gt;-->
            <!--                        <div class="attachment-block clearfix">-->
            <!--                            <img class="attachment-img" src="/img/photo2.png" alt="Attachment Image">-->

            <!--                            <div class="attachment-pushed">-->
            <!--                                <h4 class="attachment-heading"><a href="https://www.lipsum.com/">Lorem ipsum text-->
            <!--                                    generator</a></h4>-->

            <!--                                <div class="attachment-text">-->
            <!--                                    Description about the attachment can be placed here.-->
            <!--                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry... <a-->
            <!--                                    href="#">more</a>-->
            <!--                                </div>-->
            <!--                                &lt;!&ndash; /.attachment-text &ndash;&gt;-->
            <!--                            </div>-->
            <!--                            &lt;!&ndash; /.attachment-pushed &ndash;&gt;-->
            <!--                        </div>-->
            <!--                        &lt;!&ndash; /.attachment-block &ndash;&gt;-->

            <!--                        &lt;!&ndash; Social sharing buttons &ndash;&gt;-->
            <!--                        <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i>-->
            <!--                            Share-->
            <!--                        </button>-->
            <!--                        <button type="button" class="btn btn-default btn-sm"><i class="far fas fa-heart"></i>-->
            <!--                            Like-->
            <!--                        </button>-->
            <!--                        <span class="float-right text-muted">45 likes - 2 comments</span>-->
            <!--                    </div>-->
            <!--                    &lt;!&ndash; /.card-body &ndash;&gt;-->
            <!--                    <div class="card-footer card-comments">-->
            <!--                        <div class="card-comment">-->
            <!--                            &lt;!&ndash; User image &ndash;&gt;-->
            <!--                            <img class="img-circle img-sm" src="/img/user1-128x128.jpg"-->
            <!--                                 alt="User Image">-->

            <!--                            <div class="comment-text">-->
            <!--                                <span class="username">-->
            <!--                                    Maria Gonzales-->
            <!--                                    <span class="text-muted float-right">8:03 PM Today</span>-->
            <!--                                </span>&lt;!&ndash; /.username &ndash;&gt;-->
            <!--                                It is a long established fact that a reader will be distracted-->
            <!--                                by the readable content of a page when looking at its layout.-->
            <!--                            </div>-->
            <!--                            &lt;!&ndash; /.comment-text &ndash;&gt;-->
            <!--                        </div>-->
            <!--                        &lt;!&ndash; /.card-comment &ndash;&gt;-->
            <!--                        <div class="card-comment">-->
            <!--                            &lt;!&ndash; User image &ndash;&gt;-->
            <!--                            <img class="img-circle img-sm" src="/img/user1-128x128.jpg"-->
            <!--                                 alt="User Image">-->

            <!--                            <div class="comment-text">-->
            <!--                                <span class="username">-->
            <!--                                    Nora Havisham-->
            <!--                                    <span class="text-muted float-right">8:03 PM Today</span>-->
            <!--                                </span>&lt;!&ndash; /.username &ndash;&gt;-->
            <!--                                The point of using Lorem Ipsum is that it hrs a morer-less-->
            <!--                                normal distribution of letters, as opposed to using-->
            <!--                                'Content here, content here', making it look like readable English.-->
            <!--                            </div>-->
            <!--                            &lt;!&ndash; /.comment-text &ndash;&gt;-->
            <!--                        </div>-->
            <!--                        &lt;!&ndash; /.card-comment &ndash;&gt;-->
            <!--                    </div>-->
            <!--                    &lt;!&ndash; /.card-footer &ndash;&gt;-->
            <!--                    <div class="card-footer">-->
            <!--                        <form action="#" method="post">-->
            <!--                            <img class="img-fluid img-circle img-sm" src="/img/user1-128x128.jpg"-->
            <!--                                 alt="Alt Text">-->
            <!--                            &lt;!&ndash; .img-push is used to add margin to elements next to floating images &ndash;&gt;-->
            <!--                            <div class="img-push">-->
            <!--                                <input type="text" class="form-control form-control-sm"-->
            <!--                                       placeholder="Press enter to post comment">-->
            <!--                            </div>-->
            <!--                        </form>-->
            <!--                    </div>-->
            <!--                    &lt;!&ndash; /.card-footer &ndash;&gt;-->
            <!--                </div>-->
            <!--                &lt;!&ndash; /.card &ndash;&gt;-->
            <!--            </div>-->
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <modal name="create-update-post-modal"
               :adaptive="true"
               :pivot-y="0.5"
               :pivot-x="0.5"
                @before-open="beforePostCreateUpdateModalOpen"
               @closed="editData = {}"
               :width="800"
               :height="450"
        >
            <post-create-update-modal
            :sessionData="sessionData"
            :editData="editData"
            @postCreated="updateTimelinePost"
            @postUpdated="updateTimelinePost"
            @closeModal="closeModal"
            />
        </modal>
        <v-dialog/>
    </div>
</template>

<script>
import PostCreateUpdateModal from './PostCreateUpdateModal.vue';
import Posts from "./Posts";
import SinglePost from "./SinglePost";

export default {
    components: {
        Posts,
        SinglePost,
        PostCreateUpdateModal,
    },
    name: "Home",
    data() {
        return {
            posts: [],
            sessionData: [],
            editData: {},
        }
    },
    methods: {
        beforePostCreateUpdateModalOpen(event) {
            if (event.params.post) {
                this.editData = event.params.post;
            }
        },
        showPostCreateUpdateModal: function () {
            this.$modal.show('create-update-post-modal', {
                post: null
            });
        },
        closeModal: function () {
            this.editData = {};
            this.$modal.hide('create-update-post-modal');
        },
        updateTimelinePost: function (data) {
            this.fetchPosts();
            this.closeModal();
        },
        editPost: function (post) {
            this.$modal.show('create-update-post-modal', {
                post: post
            });
        },
        deletePost: function (post) {
            try {
                axios.delete(`/api/v1/posts/${post.id}`);
                this.$toast.success('Post deleted successfully');
                this.fetchPosts();
            } catch (error) {
                console.log(error);
                this.$toast.error('Something went wrong');
            }
            console.log(post);
        },
        fetchStaticData: async function () {
            try {
                const {data: {data}} = await axios.get('/api/v1/static-data-for-home-page');
                this.sessionData = data;
            } catch (error) {
                console.log(error);
                this.$toast.error('Something went wrong');
            }
        },
        fetchPosts: async function () {
            try {
                const {data: {data}} = await axios.get('/api/v1/posts');
                this.posts = data;
            } catch (error) {
                console.log(error);
                this.$toast.error('Something went wrong');
            }
        }
    },
    mounted() {
        this.fetchStaticData();
        this.fetchPosts();
    }
}
</script>

<style scoped>

</style>
