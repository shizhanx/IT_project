<template>
  <div>
    <p class="company">我的姐姐们的合照</p>
    <div class="listContainer">
      <swiper indicator-dots indicator-color="pink" indicator-active-color="green">
        <swiper-item>
          <img @click="toDetail" src="/static/images/11.jpg" alt="">
        </swiper-item>
        <swiper-item>
          <img src="/static/images/12.jpg" alt="">
        </swiper-item>
        <swiper-item>
          <img src="/static/images/13.jpg" alt="">
        </swiper-item>
      </swiper>
    </div>
    <div>
      超级无敌棒！！！
      超级无敌棒！！！
    </div>
    <div>
      超级无敌棒！！！
      超级无敌棒！！！
    </div>
    <div>
      超级无敌棒！！！
      超级无敌棒！！！
    </div>
    <div>
      超级无敌棒！！！
      超级无敌棒！！！
    </div>
    <div  @click="toDetail">
      超级无敌棒！！！
      超级无敌棒！！！
    </div>
    <div class="avatar-wrapper">
      <ImageView
        :src="avatar"
        round
        height="100%"
        mode="scaleToFill"
      />
    </div>
    <div class="nickname">{{nickname}}</div>
  </div>
</template>

<script>
  export default {
    props: {
      data: Object
    },
    methods: {
      toDetail () {
        wx.switchTab({
          url: '/pages/index/main'
        })
      }
    },
    computed: {
      avatar() {
        return (this.data && this.data.userInfo && this.data.userInfo.avatarUrl) || ''
      },
      nickname() {
        return (this.data && this.data.userInfo && this.data.userInfo.nickName) || ''
      }
    }
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
  .company {
    font-size: 40rpx;
    font-weight: bold;
    padding: 10rpx;
  }
  .avatar-wrapper {
    width: 20px;
    height: 20px;
  }

</style>
