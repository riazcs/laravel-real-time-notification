<template>
  <div class="container">
    <div class="card p-3">
      Notifications:
      <div class="card-body" v-if="notifications">
        <div
          class="alert alert-info alert-dismissible fade show"
          id="redAlert"
          role="alert"
          v-for="notify in notifications"
          :key="notify"
        >
          <strong>{{ notify.data.user_name }}</strong> Liked your post
          <b>{{ notify.data.post_title }}</b>
        </div>
      </div>
    </div>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Author</th>
          <th scope="col">Post_Action</th>
        </tr>
      </thead>
      <tbody>
        <template v-for="post in posts" :key="post.id">
          <tr>
            <th scope="row">1</th>
            <td>{{ post.title }}</td>
            <td>{{ post.user.name }}</td>
            <td>
              <button type="btn btn-sm btn-info" @click="LikePost(post.id)">
                Like
              </button>
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>
<script>
import { ref, onMounted } from "vue";
import Notify from "./PostNotify.vue";
export default {
  props: ["posts", "user", "user_notifications"],
  components: {
    notify: Notify,
  },

  data() {
    return {
      posts: this.posts,
      notifications: this.user_notifications,
    };
  },

  created() {

    Echo.private(`users.${this.user.id}`).listen('PostLikeNotificationEvent',(event) => {
      console.log(event.post.title);
      let notifs = {
        post_title: event.post.title,
        user_name : event.user.name
      }
      console.log(notifs);
    });


    Echo.private("users." + this.user.id).notification((notification) => {
      this.notifications.value.push(notification.notification);
      console.log(notification);
    });
  },
  methods: {
    LikePost(id) {
      axios.post("post-like", { post_id: id });
    },
  },
};
</script>