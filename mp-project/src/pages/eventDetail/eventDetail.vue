<template>
    <div class="listContainer">
      <img :src=event.image alt="">
      <div>
        <div class="tmpContainer">
          <div class="avatar_date">
            <img :src=current_user.image alt="">
            <van-tag type="primary">{{current_user.name}}</van-tag>
            <van-tag mark plain type="primary">{{event.date}}</van-tag>
          </div>
          <p class="company">{{event.name}}</p>
          <p class="content">{{event.description}}</p>
          <van-divider contentPosition="left">参与人</van-divider>
          <div v-for="(user, index) in registered_users" :key="index">
            <van-tag type="danger" @click="onClickUser(user.user)">{{user.user}}</van-tag>
          </div>
          <div class="add" v-if="joined==='0'">
            <van-button icon="add-o" @click="onJoinClick" type="info">要打架了，算我一个</van-button>
          </div>
          <div class="add" v-if="joined==='1'">
            <van-button icon="add-o" @click="onQuitClick" type="danger">不打架了，溜了溜了</van-button>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
  import ListTmp from '../list_template/list_template.vue'
  import {getStorageSync, setStorageSync} from '../../api/wechat'

  export default {
    components: {ListTmp},
    data() {
      return {
        event: getStorageSync('current_event'),
        current_user: getStorageSync('current_user'),
        registered_users: {},
        joined: ''
      }
    },
    methods: {
      onJoinClick() {
        this.$httpWX.post({
          url: 'relation/mycreate/userevent',
          data: {
            user: this.current_user['name'],
            event: this.event['name']
          }
        }).then(res => {
          this.joined = '1'
        })
        this.refresh()
      },
      onQuitClick() {
        this.$httpWX.post({
          url: 'relation/userUnregister',
          data: {
            user: this.current_user['name'],
            event: this.event['name']
          }
        }).then(res => {
          this.joined = '0'
        })
        this.refresh()
      },
      refresh() {
        this.$httpWX.post({
          url: 'relation/mysearch/userevent',
          data: {
            search_by: 'event',
            value: this.event.name
          }
        }).then(res => {
          this.registered_users = res
        })
      },
      onClickUser(name) {
        setStorageSync('view_user', name)
        this.$router.push({path: '/pages/userDetail/main'})
      }
    },
    onShow() {
      this.joined = '1'
      this.current_user = getStorageSync('current_user')
      this.event = getStorageSync('current_event')
      this.$httpWX.post({
        url: 'relation/mysearch/userevent',
        data: {
          search_by: 'event',
          value: this.event.name
        }
      }).then(res => {
        this.registered_users = res
        for (var i in res) {
          if (res[i]['user'] === this.current_user['name']) {
            this.joined = '1'
          }
        }
      })
    }
  }
</script>

<style lang="scss">
  .listContainer img {
    width: 100%;
    height: 400rpx;
  }

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
  .detail-stat-readers {
    display: flex;
    font-size: 12px;
    color: #909090;

    .detail-stat-readers-avatar {
      width: 25px;
      height: 25px;
      margin-left: -8px;
      border-radius: 50%;
      border: 1px solid #ccc;
      box-shadow: 0 4px 4px rgba(0, 0, 0, .3)
    }
  }
  .add {
    position: fixed;
    right: 20px;
    bottom: 20px;
  }
</style>
