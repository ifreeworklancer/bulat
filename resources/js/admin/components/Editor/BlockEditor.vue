<template>
    <div class="block-editor">
        <div class="block-editor__header d-flex justify-content-between align-items-start">
            <h4 class="flex-shrink-1 mb-0" v-if="title">{{ title }}</h4>

            <div class="lang-switcher btn-group ml-auto" v-if="multilang !== 'false'">
                <button type="button" class="btn btn-sm"
                        v-for="(lang, index) in langs" :key="index"
                        :class="current === index ? 'btn-primary' : 'btn-dark'"
                        @click.prevent="current = index">
                    {{ lang }}
                </button>
            </div>
        </div>

        <div class="block-editor__body">
            <template v-if="multilang !== 'false'">
                <div v-show="current === 0">
                    <slot name="ru"></slot>
                </div>
                <div v-show="current === 1">
                    <slot name="en"></slot>
                </div>
            </template>

            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            multilang: String
        },
        data() {
            return {
                current: 0,
                langs: [
                    'Русский',
                    'English'
                ]
            }
        },
        mounted() {

        }
    }
</script>
