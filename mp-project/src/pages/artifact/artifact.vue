<template>
  <div>
    <SearchBar
      :disabled="false"
      ref="ch"
      hot-search='请搜索传家宝'
    />
    <van-button plain icon="completed" type="primary" @click="onClickSearch">搜索</van-button>
    <van-divider />
    <div v-if="searching === '0'">
      <div
        v-for="(artifact,i) in artifacts"
        :key="i"
      >
        <van-divider />
        <van-card
          :desc=artifact.description
          :title=artifact.name
          :thumb=artifact.image
        />
      </div>
    </div>
    <div v-if="searching === '1'">
      <div
        v-for="(artifact,i) in artifacts"
        :key="i"
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
      this.$httpWX.post({
        url: 'objects/artifact/search/include',
        data: {
          search: ''
        }
      }).then(res => {
        this.artifacts = res
      })
    }
  }
</script>

<style lang="scss" scoped>
  .add {
    position: fixed;
    right: 20px;
    bottom: 20px;
  }
</style>
