<template>
    <div class="block-editor">
        <div class="block-editor__header d-flex justify-content-between align-items-start">
            <h4 class="flex-shrink-1 mb-0" v-if="title">{{ title }}</h4>

            <div class="lang-switcher btn-group ml-auto" v-if="multilang !== 'false'">
                <button type="button" class="btn btn-sm"
                        v-if="locales.length > 1"
                        v-for="(lang, index) in locales" :key="index"
                        :class="current === lang ? 'btn-primary' : 'btn-dark'"
                        @click.prevent="current = lang">
                    {{ langs[lang] }}
                </button>
            </div>
        </div>

        <div class="block-editor__body">
            <template v-if="multilang !== 'false'">
                <div v-for="locale in locales" v-show="current === locale">
                    <slot :name="locale"></slot>
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
        current: 'uk',
        locales: JSON.parse(document.querySelector('[name="locales"]').content),
        langs: {
          ru: 'Русский',
          //en: 'English',
          uk: 'Украинский'
        }
      }
    },
    mounted() {
      this.current = this.locales[0]
    }
  }
</script>
