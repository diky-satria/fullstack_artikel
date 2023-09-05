<template>
  <LayoutView>
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <div>Semua data artikel</div>
        <router-link to="/master/tambah" class="btn btn-sm btn-primary"
          >Tambah</router-link
        >
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Publikasi</th>
                <th>Dilihat</th>
                <th>Opsi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(r, index) in rows" :key="index">
                <td>
                  {{
                    r.judul.length > 50
                      ? r.judul.substring(0, 30) + "....."
                      : r.judul
                  }}
                </td>
                <td>{{ r.penulis }}</td>
                <td>{{ r.kategori }}</td>
                <td>{{ r.tanggal_publikasi }}</td>
                <td>
                  <span class="badge rounded-pill bg-info text-dark"
                    >{{ r.view }}x</span
                  >
                </td>
                <td>
                  <router-link
                    :to="{ name: 'master_detail', params: { id: r.id } }"
                    class="btn btn-sm btn-info"
                    >Detail</router-link
                  >
                  <router-link
                    :to="{ name: 'master_edit', params: { id: r.id } }"
                    class="btn btn-sm btn-success mx-1"
                    >Edit</router-link
                  >
                  <button
                    @click="hapusArtikel(r.id)"
                    class="btn btn-sm btn-danger"
                  >
                    Hapus
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </LayoutView>
</template>

<script>
import LayoutView from "../Layout/LayoutView.vue";
import { onMounted, ref } from "vue";
import Swal from "sweetalert2";
import axios from "axios";
export default {
  name: "MasterView",
  components: {
    LayoutView,
  },
  setup() {
    const rows = ref([]);

    const getArtikel = async () => {
      try {
        let response = await axios.get("/artikel");
        rows.value = response.data.data;
      } catch (e) {
        console.log(e);
      }
    };

    const hapusArtikel = (id) => {
      Swal.fire({
        title: "Apa kamu yakin ?",
        text: "ingin menghapus artikel ini",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Kembali",
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post(`/artikel/hapus/${id}`);

          getArtikel();

          Toast.fire({
            icon: "success",
            title: "Artikel berhasil dihapus",
          });
        }
      });
    };

    //sweetalert
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
      iconColor: "green",
      background: "rgb(91, 255, 96)",
    });

    onMounted(() => {
      getArtikel();
    });

    return {
      rows,
      getArtikel,
      hapusArtikel,
      Toast,
    };
  },
};
</script>

<style></style>
