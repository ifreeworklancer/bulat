<template>
    <div>
        <div class="row images-list mb-2" v-if="images.length">
            <div class="col-md-6 col-lg-4" v-for="(image, index) in images">
                <div class="image-preview rounded"
                     :style="{backgroundImage: `url(${image.src})`}">
                    <a @click.prevent="removeImage(index, image.remove)" v-if="image !== ''"
                       class="btn btn-danger btn-delete d-flex justify-content-center align-items-center">
                        <i class="material-icons text-white m-0">delete</i>
                    </a>
                </div>
            </div>
        </div>

        <label class="position-relative image-uploader d-block rounded bg-light p-4">
            <input type="file" accept="image/*" multiple @change="handleImages">

            <div class="text-center">
                Загрузить изображения
                <div v-if="tooltip">({{ tooltip }})</div>
            </div>
        </label>

        <input type="hidden" name="media[]" v-for="m in images" :key="m.id" :value="m.id">
    </div>
</template>

<script>
  export default {
    props: {
      src: Array,
      name: {
        type: String,
        default() {
          return 'images';
        }
      },
      tooltip: String,
    },
    data() {
      return {
        images: this.src || [],
        loading: false
      }
    },
    methods: {
      async uploadFile(formData) {
        await axios.post('/admin/media/upload', formData)
          .then(({data}) => {
            this.images.push(data);
          });
      },

      handleImages(event) {
        const fileList = event.target.files;

        if (!fileList.length) return;

        for (let i = 0; i < event.target.files.length; i++) {
          const formData = new FormData();
          let file = fileList[i];
          formData.set('image', file);

          this.uploadFile(formData);
        }
      },

      removeImage(index, route) {
        if (!!route) {
          axios.delete(route);
        }

        this.images.splice(index, 1);
      }
    }
  }
</script>

<style lang="scss" scoped>
    .previews {
        margin: -0.5rem;
    }

    .images-list {
        margin: -5px;

        [class^="col"] {
            padding: 5px;
        }
    }

    .image-preview {
        position: relative;
        background-size: cover;
        background-position: 50% 50%;
        padding-top: 100%;
        overflow: hidden;

        .btn-delete {
            opacity: 0;
            padding: 0;
            position: absolute;
            top: 12px;
            right: 12px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            transition: 0.35s;
            transform: scale(0);

            svg {
                margin: auto;
                fill: #fff;
            }
        }

        &:hover {
            .btn-delete {
                opacity: 1;
                visibility: visible;
                transform: scale(1);
            }
        }
    }

    .image-uploader {
        overflow: hidden;

        [type="file"] {
            position: absolute;
            left: -9999px;
        }
    }

    .material-icons {
        font-size: 14px;
    }
</style>