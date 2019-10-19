<template>
  <div>
    <div class="listContainer">
      <swiper indicator-dots indicator-color="pink" indicator-active-color="green">
        <swiper-item>
          <img src="/static/images/11.jpg" alt="">
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
      {{family_description}}
    </div>
    <van-divider />
    <van-sidebar :active="active">
      <van-sidebar-item title="祖辈" @click="onClickGeneration(2)"/>
      <van-sidebar-item title="父辈" @click="onClickGeneration(1)"/>
      <van-sidebar-item title="同辈" @click="onClickGeneration(0)"/>
      <van-sidebar-item title="子辈" @click="onClickGeneration(-1)"/>
      <van-sidebar-item title="孙辈" @click="onClickGeneration(-2)"/>
    </van-sidebar>
    <div class="renwu">
      <van-grid :gutter="30" :column-num="2">
        <van-grid-item
          v-for="(user,i) in users" :key="i"
          icon="user-o" :text=user.title @click="onClickUser(user.user2)"/>
      </van-grid>
    </div>
    <div class="add">
      <van-button icon="add-o" @click="toAddMemberClick" >添加家族成员</van-button>
    </div>
  </div>
</template>

<script>
  import {getStorageSync} from '../../api/wechat'

  export default {
    data() {
      return {
        active: 0,
        family_description: getStorageSync('family_description'),
        users: {}
      }
    },
    methods: {
      toAddMemberClick() {
        this.$router.push({path: '/pages/addMember/main'})
      },
      onClickUser(name) {
      },
      onClickGeneration(generation) {
        this.$httpWX.post({
          url: 'relation/searchUser',
          data: {
            user1: getStorageSync('current_user'),
            generation: generation
          }
        }).then(res => {
          this.users = res
        })
      }
    },
    onShow() {
      this.$httpWX.post({
        url: 'relation/searchUser',
        data: {
          user1: getStorageSync('current_user'),
          generation: 2
        }
      }).then(res => {
        this.users = res
      })
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
