<template>
    <div @tap="toDetail" class="tmpContainer">
      <div class="avatar_date">
        <img src="/static/images/user.png" alt="">
        <span>2019</span>
      </div>
      <p class="company">寒冷冬夜的雪</p>
      <img class="detail_img" src="/static/images/4.jpg" alt="">
      <p class="content">寒冷冬夜的雪超级冰,把我手都要冻僵了,我只好不停得搓手对着手哈气(注意一定不能吹气因为吹出的气是冰的),才能不被冻僵...下次我一定要戴手套wc...真的冷不开玩笑</p>
      <div class="view_star_container">
        <img src="/static/images/5.png" alt="">
        <span>66</span>
        <img src="/static/images/6.png" alt="">
        <span>66</span>
      </div>
    </div>
</template>

<script>
  export default {
    methods: {
      toDetail () {
        wx.navigateTo({
          url: '/pages/detail/main'
        })
      }
    }
  }
</script>

<style>
  .tmpContainer{
    display: flex;
    flex-direction: column;
    border-bottom: 1rpx solid #eee;
  }
  .avatar_date{
    padding: 10rpx;
  }
  .avatar_date img {
    width: 60rpx;
    height: 60rpx;
    vertical-align: middle;
    margin-right: 10rpx;
  }
  .avatar_date span{
    font-size: 28rpx;
    color: #333;
  }
  .company {
    font-size: 40rpx;
    font-weight: bold;
    padding: 10rpx;
  }
  .detail_img {
    width: 100%;
    height: 460rpx;
  }
  .content {
    font-size: 32rpx;
    text-indent: 32rpx;
    line-height: 50rpx;
    letter-spacing: 3rpx;
  }
  .view_star_container img {
    width: 32rpx;
    height: 32rpx;
    vertical-align: middle;
    margin-left: 10rpx;
  }
  .view_star_container span {
    font-size: 28rpx;
    color: #333;
    margin-left: 10rpx;
  }
</style>
