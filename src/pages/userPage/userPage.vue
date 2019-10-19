<template>
    <div class="listContainer">
      <swiper indicator-dots indicator-color="pink" indicator-active-color="green">
        <swiper-item>
        <img src="/static/images/1.png" alt="">
        </swiper-item>
        <swiper-item>
          <img src="/static/images/2.png" alt="">
        </swiper-item>
        <swiper-item>
          <img src="/static/images/3.png" alt="">
        </swiper-item>
      </swiper>
      <div>
        <ListTmp />
      </div>
    </div>
</template>

<script>
  import ListTmp from '../list_template/list_template.vue'
  export default {
    components: {ListTmp}
  }
</script>

<style>
  .listContainer swiper {
    width: 100%;
    height: 400rpx;
  }

  .listContainer swiper img {
    width: 100%;
    height: 100%;
  }

</style>
