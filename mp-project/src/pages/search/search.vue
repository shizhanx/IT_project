<template>
  <div>
    <SearchBar
      :disabled="false"
      ref="ch"
      hot-search='请搜索事件'
    />
    <van-button plain icon="completed" type="primary" @click="onClickSearch">搜索</van-button>
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
  import SearchBar from '../../components/home/SearchBar'
  import {setStorageSync} from '../../api/wechat'

  export default {
    components: {
      SearchBar
    },
    data() {
      return {
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
    }
  }
</script>

<style scoped>

</style>
