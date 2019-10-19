<template>
  <div>
    <div class="listContainer">
      <swiper indicator-dots indicator-color="pink" indicator-active-color="green">
        <swiper-item>
          <img @tap="tetail" src="/static/images/11.jpg" alt="">
        </swiper-item>
        <swiper-item>
          <img @tap="tetail" src="/static/images/12.jpg" alt="">
        </swiper-item>
        <swiper-item>
          <img src="/static/images/13.jpg" alt="">
        </swiper-item>
      </swiper>
    </div>
    <div  @tap="tetail">
      超级无敌棒！！！
      超级无敌棒！！！
    </div>
    <van-divider />
    <van-sidebar :active="active" @change="onChange">
      <van-sidebar-item title="高祖辈" @click="gudo"/>
      <van-sidebar-item title="曾祖辈" />
      <van-sidebar-item title="祖辈" />
      <van-sidebar-item title="父辈" />
      <van-sidebar-item title="同辈" />
      <van-sidebar-item title="子辈" />
      <van-sidebar-item title="孙辈" />
      <van-sidebar-item title="曾孙辈" />
    </van-sidebar>
    <div class="renwu">
      <van-grid>
        <van-grid-item icon="user-o" text="爷爷" />
        <van-grid-item icon="user-o" text="奶奶" />
        <van-grid-item icon="user-o" text="外公" />
        <van-grid-item icon="user-o" text="外婆" />
        <van-grid-item icon="user-o" text="叔祖父" />
        <van-grid-item icon="user-o" text="祖姑父" />
      </van-grid>
    </div>
    <div class="add">
      <van-button icon="add-o" @click="toAddMemberClick" >添加家族成员</van-button>
    </div>
  </div>
</template>

<script>
  export default {
    Page() {
      return {
        active: 0
      }
    },
    methods: {
      onChange(event) {
        wx.showToast({
          icon: 'none',
          title: `切换至第${event.detail}项`
        })
      },
      tetail () {
        wx.navigateTo({
          url: '/pages/userPage/main'
        })
      },
      gudo() {
        console.log()
      },
      toAddMemberClick() {
        this.$router.push({path: '/pages/addMember/main'})
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

  .renwu {
    position: absolute;
    top: 245px;
    left: 93px;
  }

  .add {
    position: absolute;
    right: 20px;
    bottom: 20px;
  }

</style>
