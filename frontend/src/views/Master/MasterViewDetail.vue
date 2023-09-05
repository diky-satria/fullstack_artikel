<template>
  <LayoutView>
    <div class="row justify-content-center detail">
      <div class="col-lg-5 col-xl-6 col-md-6 col-sm-12">
        <div class="row">
          <div class="col">
            <img :src="url + '/thumbnail/' + state.thumbnail" alt="logo" />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h3>{{ state.judul }}</h3>
            <h6>Kategori: {{ state.kategori }}</h6>
            <h6>Penulis: {{ state.penulis }}</h6>
            <h6>
              Dilihat:
              <span class="badge rounded-pill bg-info text-dark"
                >{{ state.view }}x</span
              >
            </h6>
            <div v-html="state.konten" style="margin-top: 20px"></div>
          </div>
        </div>
      </div>
    </div>
  </LayoutView>
</template>

<script>
import LayoutView from "../Layout/LayoutView.vue";
import { useRoute } from "vue-router";
import { onMounted, ref } from "vue";
import axios from "axios";
export default {
  name: "MasterViewTambah",
  components: {
    LayoutView,
  },
  setup() {
    const par = useRoute();
    const state = ref([]);
    const url = process.env.VUE_APP_URL_API;

    const getDetail = async () => {
      let response = await axios.get(`/artikel/${par.params.id}`);
      state.value = response.data.data;
    };

    onMounted(() => {
      getDetail();
    });

    return {
      par,
      state,
      url,
      getDetail,
    };
  },
};
</script>

<style>
.detail img {
  width: 100%;
  height: 300px;
  object-fit: cover !important;
  border-radius: 10px;
}
.detail h6 {
  font-size: 14px;
}
</style>
