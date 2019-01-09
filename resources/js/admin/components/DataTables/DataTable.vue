<template>
    <div class="data-table">
        <data-table-header></data-table-header>
        <slot name="body"></slot>
    </div>
</template>

<script>
    import DataTableHeader from './DataTableHeader';
    export default {
        components: {
            DataTableHeader
        },
        data() {
            return {
                selected: []
            }
        },
        mounted() {
            VBUS.$on('table-change', (item) => {
                if (this.selected.indexOf(item) > -1) {
                    this.selected = this.selected.filter(i => i !== item);
                } else {
                    this.selected.push(item);
                }
            })
        }
    }
</script>
