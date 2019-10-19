<template>
  <div>
    <SearchBar
      :disabled="false"
      ref="ch"
      hot-search='请搜索关键词'
    />
    <van-button plain icon="completed" type="primary" @click="onClickSearch">搜索</van-button>
    <van-divider />
    <div v-if="searching === '0'">
      <van-card
        desc="满满的垃圾 爽！"
        title="垃圾桶"
        thumb="/static/images/40.png"
      />
      <van-divider />
      <van-card
        desc="墨大Software Systems本科在读，正在毕业的边缘疯狂试探"
        title="客户之子"
        thumb="/static/images/42.jpg"
      />
      <van-divider />
      <van-card
        desc="儿子的偶像，具体信息请咨询客户之子"
        title="偶像"
        thumb="/static/images/43.jpg"
      />
      <van-divider />
      <van-card
        desc="没开的宝箱，开出啥都有可能"
        title="未开宝箱"
        thumb="/static/images/44.png"
      />
    </div>
    <div v-if="searching === '1'">
      <div
        v-for="(artifact,i) in artifacts"
        :key="i"
        @click='onClickArtifact()'
      >
        <van-divider />
        <van-card
          :desc=artifact.description
          :title=artifact.name
          :thumb=artifact.image
        />
      </div>
    </div>
    <div class="add">
      <van-button icon="add-o" @click="toAddArtifactClick">添加传家宝</van-button>
    </div>
  </div>
</template>

<script>
  import SearchBar from '../../components/home/SearchBar'

  export default {
    components: {
      SearchBar
    },
    data() {
      return {
        artifacts: {},
        searching: ''
      }
    },
    methods: {
      toAddArtifactClick() {
        this.$router.push({path: '/pages/addArtifact/main'})
      },
      onClickSearch() {
        let chil = this.$refs.ch
        console.log(chil.searchWord)
        this.$httpWX.post({
          url: 'objects/artifact/search/include',
          data: {
            search: chil.searchWord
          }
        }).then(res => {
          if (!res[0]) {
            wx.showToast({title: '空无一物', icon: 'none'})
          } else {
            this.searching = '1'
            this.artifacts = res
          }
        })
      }
    },
    onShow() {
      this.searching = '0'
    }
  }
</script>

<style lang="scss" scoped>
  .add {
    position: absolute;
    right: 20px;
    bottom: 20px;
  }
</style>
