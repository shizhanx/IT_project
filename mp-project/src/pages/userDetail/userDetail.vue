<template>
    <div class="listContainer">
      <div class="avatar-wrapper" @click="onClickUser(current_user.name)">
        <ImageView
          :src=user.image
          round
          height="100%"
          mode="scaleToFill"
        />
      </div>
      <div>
        <div class="tmpContainer">
          <div class="company"><van-tag color="#000000" size="large">{{user.name}}</van-tag></div>
          <div class="content"><van-tag color="#99FFFF" text-color="#009FCC">{{user.description}}</van-tag></div>
          <van-divider contentPosition="left">参与活动</van-divider>
          <div v-for="(event, index) in registered_events" :key="index">
            <div @click="onClickEvent(event)">
              <van-tag type="danger">{{event.name}}</van-tag>
              <image-view :src="event.image"></image-view>
            </div>
          </div>
        </div>
      </div>
      <div class="add">
        <van-tag round size="large" color="#007799" text-color="#DDDDDD" @click="toFamilyTreeClick">返回族谱</van-tag>
      </div>
    </div>
</template>

<script>
  import ListTmp from '../list_template/list_template.vue'
  import {getStorageSync, setStorageSync} from '../../api/wechat'
  import ImageView from '../../components/base/ImageView'

  export default {
    components: {ImageView, ListTmp},
    data() {
      return {
        user: {},
        registered_events: {}
      }
    },
    methods: {
      onClickEvent (event) {
        setStorageSync('current_event', event)
        this.$router.push({path: '/pages/eventDetail/main'})
      },
      toFamilyTreeClick () {
        wx.switchTab({
          url: '/pages/familyTree/main'
        })
      }
    },
    onShow() {
      this.$httpWX.post({
        url: 'objects/user/search/exact',
        data: {
          search: getStorageSync('view_user')
        }
      }).then(res => {
        this.user = res[0]
      })
      this.$httpWX.post({
        url: 'objects/event/searchAllEvents',
        data: {
          current_user: getStorageSync('view_user')
        }
      }).then(res => {
        this.registered_events = res
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
  .avatar-wrapper {
    width: 200px;
    height: 200px;
  }
  .add {
    position: fixed;
    right: -2px;
    top: 50px;
  }
</style>
