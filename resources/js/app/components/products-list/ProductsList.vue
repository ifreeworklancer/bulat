<template>
    <div class="row" v-view="viewHandler">
            <product-item
                    v-if="items.length"
                    v-for="product in items"
                    :product="product"
                    :key="product.id"/>

        <div class="col-12" v-show="loading">
            <div class="lds-ripple">
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="col-12 text-center" v-if="!loading && !items.length">
            {{nothing}}
        </div>
    </div>
</template>

<script>
  import axios from 'axios'
  import ProductItem from './ProductsListItem'

  export default {
    props: {
      query: Object | Array,
      nothing: String
    },
    components: {
      ProductItem
    },
    data() {
      return {
        items: [],
        loading: false,
        pagination: {
          current: 1,
          next: 1,
          total: 1
        }
      }
    },
    methods: {
      viewHandler(e) {
        if (e.percentCenter < 0 && !this.loading && (!!this.pagination.next && this.pagination.next > 1)) {
          this.getItems();
        }
      },

      getItems() {
        this.loading = true;

        axios.get('/api/products', {
          params: {...this.query, page: this.pagination.next}
        }).then(({data}) => {
          this.loading = false;
          this.items.push(...data.items);
          this.pagination = data.pagination;
        })
      }
    },
    mounted() {
      this.getItems();
    }
  }
</script>

<style lang="scss">
    .lds-ripple {
        position: relative;
        width: 64px;
        height: 64px;
        margin: 0 auto;
    }

    .lds-ripple div {
        position: absolute;
        border: 4px solid #DAA520;
        opacity: 1;
        border-radius: 50%;
        animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
    }

    .lds-ripple div:nth-child(2) {
        animation-delay: -0.5s;
    }

    @keyframes lds-ripple {
        0% {
            top: 28px;
            left: 28px;
            width: 0;
            height: 0;
            opacity: 1;
        }
        100% {
            top: -1px;
            left: -1px;
            width: 58px;
            height: 58px;
            opacity: 0;
        }
    }
</style>