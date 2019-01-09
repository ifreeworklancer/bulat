<template>
    <div class="data-table-item"
         @click="toggleSelect"
         :class="itemColor">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" v-model="selected">
            <label class="custom-control-label"></label>
        </div>
        
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            item: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                selected: false
            }
        },
        computed: {
            itemColor() {
                return this.selected ? 'bg-secondary text-white' : '';
            }
        },
        methods: {
            toggleSelect() {
                this.selected = !this.selected;
                VBUS.$emit('table-change', +this.item)
            }
        }
    }
</script>
