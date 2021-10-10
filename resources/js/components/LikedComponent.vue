<template>

  <div>
    <!-- <button @click="active01=!active01" v-bind:class="{active:active01}">押して！</button> -->
    <label v-bind:class="{heart:isHeart, 'heart-button':isHB, 'heart-liked-button':isHLB}">
      <input style="display:none;" type="checkbox" v-model="isChecked" v-on:change="changeCheckbox" v-bind:class="{heart:isHeart, 'heart-button':isHB, 'heart-liked-button':isHLB}" checked>{{ image.likes_count }}</input>
    </label>
  </div>

</template>

<script>
export default {
    name: "LikedComponent",
    props:["image"],
    data () {
        return {
          isHeart: true,
          isHB: false,
          isHLB: true,
        }
    },
    methods: {
      changeCheckbox: function() {
        if(this.isChecked){
          var self = this;
          self.isHB=false;
          self.isHLB=true;
          self.image.likes_count+=1;
          axios.post('likes_index_store', {image_id: this.image.id})
              .then(function(response){
                  // 成功したとき
              }).catch(function(error){
                  // 失敗したとき（成功ルートでもエラーが発生すればerror）
                  alert(error);
              });
        }else{
          var self = this;
          self.isHB=true;
          self.isHLB=false;
          self.image.likes_count-=1;
          axios.post('likes_index_destroy', {image_id: this.image.id})
              .then(function(response){
                  // 成功したとき
              }).catch(function(error){
                  // 失敗したとき（成功ルートでもエラーが発生すればerror）
                  alert(error);
              });
        }
      },
      onClick: function() {
        var self = this;
        axios.post('likes_index_destroy', {image_id: this.image.id})
            .then(function(response){
                // 成功したとき
                self.isHB=true;
                self.isHLB=false;
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
