<template>

  <div>
    <!-- <button @click="active01=!active01" v-bind:class="{active:active01}">押して！</button> -->
    <button v-if="isHB" class="heart heart-button" id='heart-button' @click="onClick">{{ image.likes_count }}</button>
    <button v-if="isHLB" class="heart heart-liked-button" id='heart-button' @click="onlClick">{{ image.likes_count }}</button>

  </div>

</template>

<script>
export default {
    name: "LikeComponent",
    props:["image"],
    data () {
        return {
          isHeart: true,
          isHB: true,
          isHLB: false
        }
    },
    methods: {
      onClick: function() {
        var self = this;
        axios.post('likes_index_store', {image_id: this.image.id})
            .then(function(response){
                // 成功したとき
                self.isHB=false;
                self.isHLB=true;
                self.image.likes_count+=1;
            }).catch(function(error){
                // 失敗したとき（成功ルートでもエラーが発生すればerror）
                alert(error);
            });
      },
      onlClick: function() {
        var self = this;
        axios.post('likes_index_destroy', {image_id: this.image.id})
            .then(function(response){
                // 成功したとき
                self.isHB=true;
                self.isHLB=false;
                self.image.likes_count-=1;
            }).catch(function(error){
                // 失敗したとき（成功ルートでもエラーが発生すればerror）
                alert(error);
            });
      }
    }
}
</script>

<style scoped>
    .active {
      color: red;
    }
</style>
