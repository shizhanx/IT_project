<template>
  <div>
    <div class="listContainer" @click="onClickImage">
      <img :src="familyImage" alt="" />
    </div>
    <van-tag mark color="#ffe1e1" text-color="#ad0000" size="large">{{family_description}}</van-tag>
    <van-divider />
    <van-sidebar :active="active">
      <van-sidebar-item title="祖辈" @click="onClickGeneration(2)"/>
      <van-sidebar-item title="父辈" @click="onClickGeneration(1)"/>
      <van-sidebar-item title="同辈" @click="onClickGeneration(0)"/>
      <van-sidebar-item title="子辈" @click="onClickGeneration(-1)"/>
      <van-sidebar-item title="孙辈" @click="onClickGeneration(-2)"/>
    </van-sidebar>
    <div class="renwu">
      <van-grid :gutter="10" column-num="2">
        <van-grid-item v-for="(user,i) in users" :key="i" icon="user-o" :text=user.title @click="onClickUser(user.user2)"/>
      </van-grid>
    </div>
    <div class="add">
      <van-button icon="add-o" @click="toAddMemberClick" >添加家族成员</van-button>
    </div>
    <div class="refresh">
      <van-button icon="replay" type="primary" @click="onRefreshClick" />
    </div>
  </div>
</template>

<script>
  import {getStorageSync, setStorageSync} from '../../api/wechat'
  export default {
    data() {
      return {
        active: 0,
        family_description: getStorageSync('current_family')['description'],
        users: {},
        familyImage: getStorageSync('familyImage')
      }
    },
    methods: {
      onClickImage() {
        wx.chooseImage({
          count: 1,
          sizeType: ['original', 'compressed'],
          sourceType: ['album', 'camera'],
          success (res) {
            const tempFilePaths = res.tempFilePaths
            setStorageSync('familyImage', tempFilePaths)
          }
        })
      },
      toAddMemberClick() {
        this.$router.push({path: '/pages/addMember/main'})
      },
      onRefreshClick() {
        this.familyImage = getStorageSync('familyImage')
      },
      onClickUser(name) {
        setStorageSync('view_user', name)
        this.$router.push({path: '/pages/userDetail/main'})
      },
      onClickGeneration(generation) {
        this.$httpWX.post({
          url: 'relation/searchUser',
          data: {
            user1: getStorageSync('current_user')['name'],
            generation: generation
          }
        }).then(res => {
          this.users = res
        })
      }
    },
    mounted() {
      this.family_description = getStorageSync('current_family')['description']
      this.$httpWX.post({
        url: 'relation/searchUser',
        data: {
          user1: getStorageSync('current_user')['name'],
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
    top: 355px;
    left: 122px;
  }
  .add {
    position: fixed;
    right: 20px;
    bottom: 20px;
  }
  .refresh {
    position: fixed;
    right: 188px;
    bottom: 20px;
  }
</style>
