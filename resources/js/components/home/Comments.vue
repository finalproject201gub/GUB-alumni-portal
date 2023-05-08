<template>
    <div class="card-footer card-comments" v-if="!!comments.length">
        <SingleComment v-for="comment in comments" :key="comment.id" :comment="comment"></SingleComment>
    </div>
</template>

<script>
import SingleComment from './SingleComment';
export default {
    name: "Comments",
    props: {
        comments: {
            type: Array,
            default: () => {
                []
            }
        }
    },
    components: {
        SingleComment
    },
}
</script>

<style scoped>

</style>
