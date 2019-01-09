<template>
    <div class="form-group">
        <label v-text="label" v-if="label"></label>
        <input type="hidden" :name="name" :value="data.html">

        <quill-editor
            :content="content"
            :options="editorOptions"
            @change="onEditorChange"/>
    </div>
</template>

<script>
  import {quillEditor} from 'vue-quill-editor'
  import 'quill/dist/quill.core.css'
  import 'quill/dist/quill.snow.css'

  export default {
        props: {
            name: {
                type: String,
                default: () => 'body'
            },
            label: String,
            content: {
                type: String,
                default: () => ''
            }
        },
        components: {
            quillEditor
        },
        data() {
            return {
                data: {
                    html: this.content
                },
                editorOptions: {
                    modules: {
                        toolbar: [
                            [{header: [2, 3, 4, 5, false]}],
                            [{'align': []}],
                            [{'list': 'ordered'}, {'list': 'bullet'}],
                            ['bold', 'italic', 'strike'],
                            [{script: 'sub'}, {script: 'super'}],
                            ['link'],
                        ]
                    },
                    placeholder: 'Описание'
                }
            }
        },
        methods: {
            onEditorChange(val) {
                this.data = val;
            }
        }
    }
</script>

<style>
    .ql-toolbar.ql-snow .ql-align .ql-picker-label svg {
        position: relative;
        right: initial;
        top: -4px;
    }
</style>
