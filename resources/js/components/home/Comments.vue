<template>
    <div class="card-footer card-comments" v-if="!!comments.length">
        <SingleComment v-for="comment in comments" :key="comment.id" :comment="comment"></SingleComment>
        <a href="#" @click.prevent="loadMoreComment" class="text-primary load-more-comment-btn">Load more comments</a>
    </div>
</template>

<script>
import SingleComment from './SingleComment';
export default {
    name: "Comments",
    props: {
        postId: {
            type: Number,
            default: 0
        },
        comments: {
            type: Array,
            default: () => {
                []
            }
        },
        commentCount: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            currentOffset: 0
        }
    },
    components: {
        SingleComment
    },
    methods: {
        async loadMoreComment() {
            try {
                this.comments = [];
            const {data: {data}} = await axios.get(`/api/v1/posts/comments/${this.postId}/?offset=${this.currentOffset}`);
            this.comments.push(...data);
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>

<style scoped>
.load-more-comment-btn {
    display: block;
    margin-top: 10px;
}
.load-more-comment-btn:hover {
    text-decoration: underline;
}
</style>
