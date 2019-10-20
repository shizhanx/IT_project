<template>
  <div>
    <van-divider />
    <div>
      <div
        v-for="(event,i) in events"
        :key="i"
        @click='onClickEvent(event)'
      >
        <van-divider />
        <van-card
          :desc=event.description
          :title=event.name
          :tag=event.date
          :thumb=event.image
        />
      </div>
    </div>
  </div>
</template>

<script>
  import {setStorageSync, getStorageSync} from '../../api/wechat'

  export default {
    data() {
      return {
        current_user: getStorageSync('current_user'),
        events: {}
      }
    },
    methods: {
      onClickSearch() {
        let chil = this.$refs.ch
        this.$httpWX.post({
          url: 'objects/event/search/include',
          data: {
            search: chil.searchWord
          }
        }).then(res => {
          if (!res[0]) {
            wx.showToast({title: '空无一物', icon: 'none'})
          } else {
            this.events = res
          }
        })
      },
      onClickEvent (event) {
        setStorageSync('current_event', event)
        this.$router.push({path: '/pages/eventDetail/main'})
      }
    },
    onShow() {
      this.$httpWX.post({
        url: 'objects/event/searchAllEvents',
        data: {
          current_user: this.current_user['name']
        }
      }).then(res => {
        this.events = res
      })
    }
  }
</script>

<style scoped>

</style>
