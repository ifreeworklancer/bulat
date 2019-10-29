<template>
    <div>
        <draggable v-model="images" class="row images-list mb-2">
            <div class="col-md-6 col-lg-4" v-for="(image, index) in images">
                <div class="image-preview rounded"
                     :style="{backgroundImage: `url(${image.src})`}">
                    <a @click.prevent="removeImage(index, image.remove)" v-if="image !== ''"
                       class="btn btn-danger btn-delete d-flex justify-content-center align-items-center">
                        <i class="i-trash text-white m-0"></i>
                    </a>
                </div>
            </div>
        </draggable>

        <label class="position-relative image-uploader d-block rounded bg-light p-4">
            <input type="file" accept="image/*" multiple @change="handleImages">

            <div class="text-center">
                <template v-if="!loading">Загрузить изображения</template>

                <div class="lds-css ng-scope" v-if="loading">
                    <div style="width:100%;height:100%" class="lds-flickr">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </label>

        <input type="hidden" name="media[]" v-for="m in images" :key="m.id" :value="m.id">
    </div>
</template>

<script>
  import Draggable from 'vuedraggable'
  export default {
    components: {
      Draggable
    },
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
      uploadFile(file) {
        this.loading = true;
        const formData = new FormData();
        formData.set('image', file);

        axios.post('/admin/media/upload', formData)
          .then(({data}) => {
            this.images.push(data);
            this.loading = false;
          });
      },

      handleImages(event) {
        const fileList = event.target.files;

        if (!fileList.length) return;

        for (let i = 0; i < event.target.files.length; i++) {
          this.uploadFile(fileList[i]);
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

    @keyframes lds-flickr-opacity {
        0% {
            -webkit-transform: translate(0 0);
            transform: translate(0 0);
            opacity: 1;
        }
        49.99% {
            opacity: 1;
            -webkit-transform: translate(80px, 0);
            transform: translate(80px, 0);
        }
        50% {
            opacity: 0;
            -webkit-transform: translate(80px, 0);
            transform: translate(80px, 0);
        }
        100% {
            opacity: 0;
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }
    }

    @-webkit-keyframes lds-flickr-opacity {
        0% {
            -webkit-transform: translate(0 0);
            transform: translate(0 0);
            opacity: 1;
        }
        49.99% {
            opacity: 1;
            -webkit-transform: translate(80px, 0);
            transform: translate(80px, 0);
        }
        50% {
            opacity: 0;
            -webkit-transform: translate(80px, 0);
            transform: translate(80px, 0);
        }
        100% {
            opacity: 0;
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }
    }

    @keyframes lds-flickr {
        0% {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }
        50% {
            -webkit-transform: translate(80px, 0);
            transform: translate(80px, 0);
        }
        100% {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }
    }

    @-webkit-keyframes lds-flickr {
        0% {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }
        50% {
            -webkit-transform: translate(80px, 0);
            transform: translate(80px, 0);
        }
        100% {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }
    }

    .lds-flickr {
        position: relative;
    }

    .lds-flickr div {
        position: absolute;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        top: 60px;
        left: 20px;
    }

    .lds-flickr div:nth-child(1) {
        background: #a12d2b;
        -webkit-animation: lds-flickr 1.8s linear infinite;
        animation: lds-flickr 1.8s linear infinite;
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .lds-flickr div:nth-child(2) {
        background: #be8039;
        -webkit-animation: lds-flickr 1.8s linear infinite;
        animation: lds-flickr 1.8s linear infinite;
        -webkit-animation-delay: 0s;
        animation-delay: 0s;
    }

    .lds-flickr div:nth-child(3) {
        background: #a12d2b;
        -webkit-animation: lds-flickr-opacity 1.8s linear infinite;
        animation: lds-flickr-opacity 1.8s linear infinite;
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .lds-flickr {
        margin: 0 auto;
        width: 47px !important;
        height: 32px !important;
        -webkit-transform: translate(-23.5px, -23.5px) scale(0.235) translate(23.5px, 23.5px);
        transform: translate(-23.5px, -23.5px) scale(0.235) translate(23.5px, 23.5px);
    }
</style>
