<template>
    <div class="form-group">
        <label class="position-relative image-uploader d-block"
               :class="{'bg-light': image === ''}">
            <div class="text-center p-4" v-if="image === ''">
                Загрузить изображение
            </div>

            <img :src="image" v-else>

            <input type="file" :name="name ? name : 'image'" id="image" @change="handleImage">

            <a @click.prevent="removeImage" v-if="image !== '' && image !== this.src"
               class="btn btn-danger btn-delete d-flex justify-content-center align-items-center">
                <i class="i-trash text-white"></i>
            </a>
        </label>
    </div>
</template>

<script>
    export default {
        props: {
            src: {
                type: String,
                default() {
                    return '';
                }
            },
            imageId: {
                type: String
            },
            name: String
        },
        data() {
            return {
                image: this.src
            }
        },
        methods: {
            handleImage(event) {
                if (event.target.files && event.target.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        this.image = e.target.result;
                    }.bind(this);

                    reader.readAsDataURL(event.target.files[0]);
                }
            },
            removeImage(e) {
                if (this.imageId) {
                    axios.delete(`/admin/product/media/${this.imageId}/delete`)
                        .then(() => this.image = '');
                } else {
                    this.image = '';
                    e.target.value = '';
                }
            }
        }
    }
</script>

<style lang="scss">
    .image-uploader {
        [type="file"] {
            position: absolute;
            left: -9999px;
        }

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
</style>
