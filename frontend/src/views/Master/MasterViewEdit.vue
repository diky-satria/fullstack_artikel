<template>
  <LayoutView>
    <div class="row justify-content-center">
      <div class="col-lg-5 col-xl-5 col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">Tambah artikel</div>
          <div class="card-body">
            <form @submit.prevent="editArtikel">
              <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" v-model="form.judul" />
                <span class="text-danger" v-if="errors.judul">{{
                  errors.judul
                }}</span>
              </div>
              <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select class="form-control" v-model="form.kategori">
                  <option value="berita">Berita</option>
                  <option value="programming">Programming</option>
                  <option value="olahraga">Olahraga</option>
                  <option value="kesehatan">Kesehatan</option>
                </select>
                <span class="text-danger" v-if="errors.kategori">{{
                  errors.kategori
                }}</span>
              </div>
              <div class="mb-3">
                <label class="form-label">Penulis</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="form.penulis"
                />
                <span class="text-danger" v-if="errors.penulis">{{
                  errors.penulis
                }}</span>
              </div>
              <div class="mb-3">
                <label class="form-label">Thumbnail</label>
                <div class="custom-file">
                  <input
                    type="file"
                    accept="image/*"
                    class="form-control"
                    id="customFile"
                    @change="ubahThumbnail"
                  />
                  <img
                    :src="url + '/thumbnail/' + form.thumbnail"
                    alt="logo"
                    style="width: 100px; margin: 10px 0"
                  />
                </div>
                <span class="text-danger" v-if="errors.thumbnail">{{
                  errors.thumbnail
                }}</span>
              </div>
              <div class="mb-3">
                <label class="form-label">Konten</label>
                <ckeditor
                  :editor="editor"
                  v-model="form.konten"
                  :config="editorConfig"
                ></ckeditor>
                <span class="text-danger" v-if="errors.konten">{{
                  errors.konten
                }}</span>
              </div>
              <button
                class="btn btn-sm btn-primary float-end d-flex"
                id="btn-edit"
              >
                <div>Edit</div>
                <div>
                  <svg
                    v-if="load"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    style="
                      margin: auto;
                      background: rgba(255, 255, 255, 0);
                      display: block;
                      shape-rendering: auto;
                    "
                    width="24px"
                    height="22px"
                    viewBox="0 0 100 100"
                    preserveAspectRatio="xMidYMid"
                  >
                    <g>
                      <path
                        d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843"
                        fill="none"
                        stroke="#ffffff"
                        stroke-width="12"
                      ></path>
                      <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                      <animateTransform
                        attributeName="transform"
                        type="rotate"
                        repeatCount="indefinite"
                        dur="1s"
                        values="0 50 50;360 50 50"
                        keyTimes="0;1"
                      ></animateTransform>
                    </g>
                  </svg>
                </div>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </LayoutView>
</template>

<script>
import LayoutView from "../Layout/LayoutView.vue";
import Editor from "ckeditor5-custom-build/build/ckeditor";
import { ref, onMounted } from "vue";
import router from "@/router";
import Swal from "sweetalert2";
import { useRoute } from "vue-router";
import axios from "axios";

export default {
  name: "MasterViewEdit",
  components: {
    LayoutView,
  },
  setup() {
    const par = useRoute();

    const form = ref([]);
    const url = process.env.VUE_APP_URL_API;
    const fileThumbnail = ref("");
    const errors = ref([]);
    const load = ref(false);

    const getDetail = async () => {
      let response = await axios.get("/artikel/" + par.params.id);
      form.value = response.data.data;
    };

    const ubahThumbnail = (e) => {
      if (e.target.files.length === 0) {
        fileThumbnail.value = "";
        return;
      }
      fileThumbnail.value = e.target.files[0];
    };

    const editArtikel = async () => {
      let btn = document.getElementById("btn-edit");
      try {
        btn.setAttribute("disabled", true);
        load.value = true;

        const data = new FormData();
        data.append("judul", form.value.judul);
        data.append("kategori", form.value.kategori);
        data.append("penulis", form.value.penulis);
        data.append("thumbnail", fileThumbnail.value);
        data.append("konten", form.value.konten);

        let response = await axios.post("/artikel/" + par.params.id, data);
        if (response.status === 201) {
          load.value = false;
          btn.removeAttribute("disabled", false);
          router.replace("/master");
          Toast.fire({
            icon: "success",
            title: "Artikel berhasil diedit",
          });
        }
      } catch (e) {
        load.value = true;
        errors.value = e.response.data.messages;
        load.value = false;
        btn.removeAttribute("disabled", false);
      }
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
      getDetail();
    });

    return {
      editor: Editor, // eslint-disable-line
      editorConfig: {
        toolbar: {
          items: [
            "findAndReplace",
            "selectAll",
            "|",
            "heading",
            "|",
            "bold",
            "italic",
            "strikethrough",
            "underline",
            "subscript",
            "superscript",
            "removeFormat",
            "|",
            "bulletedList",
            "numberedList",
            "todoList",
            "|",
            "outdent",
            "indent",
            "|",
            // '-',
            "fontSize",
            "fontFamily",
            "fontColor",
            "fontBackgroundColor",
            "|",
            "alignment",
            "|",
            "link",
            // "insertImage",
            // "mediaEmbed",
            // "blockQuote",
            // "insertTable",
            "|",
            "specialCharacters",
            "horizontalLine",
            // "pageBreak",
            "|",
            "undo",
            "redo",
          ],
          shouldNotGroupWhenFull: true,
        },
      },
      par,
      form,
      url,
      fileThumbnail,
      errors,
      load,
      getDetail,
      ubahThumbnail,
      editArtikel,
      Toast,
    };
  },
};
</script>

<style></style>
