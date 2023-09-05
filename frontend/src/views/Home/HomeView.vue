<template>
  <LayoutView>
    <div class="row justify-content-center">
      <div class="col-lg-3 col-xl-3 col-md-4 col-sm-12 mb-2 col-custom">
        <h5 style="color: #093b6e; font-weight: bold">SEMUA ARTIKEL</h5>
      </div>
      <div class="col-lg-3 col-xl-3 col-md-4 col-sm-12 mb-2 col-custom">
        <div class="input-group mb-3">
          <input
            type="text"
            class="form-control form-control-cari"
            placeholder="Cari judul, kategori..."
            aria-label="Cari judul, kategori..."
            aria-describedby="button-addon2"
            v-model="keyword.keyword"
          />
          <button
            class="btn btn-outline-secondary btn-cari"
            type="button"
            id="button-addon2"
            @click="cari"
          >
            Cari
          </button>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6 col-xl-6 col-md-8 col-sm-12 col-custom mb-4">
        <div
          class="row mb-3"
          v-for="(r, index) in rows"
          :key="index"
          @click="detail(r.id)"
          style="cursor: pointer"
        >
          <div class="card card-home">
            <div class="card-body card-body-home">
              <div class="row">
                <div class="col-md-3 col-sm-3 col-4">
                  <img :src="url + '/thumbnail/' + r.thumbnail" alt="logo" />
                </div>
                <div class="col-md-9 col-sm-9 col-8">
                  <h5>
                    {{
                      r.judul.length > 50
                        ? r.judul.substring(0, 30) + "....."
                        : r.judul
                    }}
                  </h5>
                  <p>Kategori: {{ r.kategori }}</p>
                  <p>Penulis: {{ r.penulis }}</p>
                  <p>
                    Dilihat:
                    <span class="badge rounded-pill bg-info text-dark"
                      >{{ r.view }}x</span
                    >
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </LayoutView>
</template>

<script>
import { onMounted, ref, reactive } from "vue";
import LayoutView from "../Layout/LayoutView.vue";
import router from "@/router";
import axios from "axios";
export default {
  name: "HomeView",
  components: {
    LayoutView,
  },
  setup() {
    const rows = ref([]);
    const keyword = reactive({
      keyword: "",
    });
    const url = process.env.VUE_APP_URL_API;

    const getArtikel = async () => {
      let response = await axios.get(
        `/artikel/home?keyword=${keyword.keyword}`
      );
      rows.value = response.data.data;
    };

    const cari = () => {
      getArtikel();
    };

    const detail = (id) => {
      router.replace(`/${id}`);
    };

    onMounted(() => {
      getArtikel();
    });

    return {
      rows,
      keyword,
      url,
      getArtikel,
      cari,
      detail,
    };
  },
};
</script>

<style>
img {
  width: 100%;
  height: 80px;
  object-fit: cover !important;
  border-radius: 10px;
}
h5 {
  font-size: 20px;
  margin-bottom: 0 !important;
}
p {
  font-size: 14px;
  margin-bottom: 0 !important;
}
.col-custom {
  text-align: left;
}
.card-home {
  background-color: transparent !important;
}
.card-body-home {
  background-color: white !important;
  border-radius: 10px !important;
}
.btn-cari {
  border: 1px solid #093b6e !important;
}
.form-control-cari {
  box-shadow: none !important;
  border-color: #093b6e !important;
}
.btn-cari:hover {
  background-color: #093b6e !important;
}
</style>
