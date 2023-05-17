<template>
    <div class="card-comment">
        <!-- User image -->
        <img class="img-circle img-sm" src="/img/user1-128x128.jpg" alt="User Image">

        <div class="comment-text">
            <span class="username">
                {{ comment.user.name }}
                <span class="text-muted float-right">{{ formatDateTimeForHuman(comment.created_at) }}</span>
            </span>
            <!-- /.username -->
            {{ comment.body }}
        </div>
        <!-- /.comment-text -->
    </div>
</template>

<script>
import moment from 'moment';
export default {
    name: "SingleComment",
    props: {
        comment: {
            type: Object,
            default: () => {
            }
        }
    },
    methods: {
        formatDateTimeForHuman: function (dateTime) {
            return moment(dateTime).fromNow();
        }
    }
}
</script>

<style scoped>

</style>
