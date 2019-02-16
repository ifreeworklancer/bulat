<template>
    <div class="col-md-6 col-lg-4">
        <a :href="product.route" class="product-preview">
            <figure class="product-preview__image"
                    :style="{backgroundImage: `url(${product.image})`}"></figure>
            <div class="product-preview__info p-3">
                <h5>{{ product.title }}</h5>

                <p class="text-body smaller" v-if="!!product.description">
                    {{ product.description }}
                </p>

                <h6 class="mb-0">
                    {{ product.price }}
                    <small class="text-uppercase currency">
                        {{ product.currency }}
                    </small>
                </h6>
            </div>
        </a>
    </div>
</template>

<script>
  export default {
    props: {
      product: Object
    }
  }
</script>