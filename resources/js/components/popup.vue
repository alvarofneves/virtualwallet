<template>
    <div class="py-4">
        <button class="btn btn-primary" @click="show=true">Open modal</button>

        <stack-modal
                :show="show"
                title="Modal #1"
                @close="show=false"
        >
            <button class="btn btn-info" @click="show_second=true">Open modal 2</button>
        </stack-modal>

        <stack-modal
                :show="show_second"
                @close="show_second=false"
        >
            <p>I have no title so the modal-header is missing.</p>

            <button class="btn btn-warning" @click="show_third=true">Open modal 3</button>
        </stack-modal>

        <stack-modal
                :show="show_third"
                @close="show_third=false"
                title="Last modal"
                :close-on-escape="false"
        >
            <p>This is the last modal. This modal has closeOnEscape set to false so you cannot close it via ESC key.</p>
        </stack-modal>

    </div>
</template>

<script>
  import StackModal from './stackModel'

  export default {
    name: "StackableModalDemo",
    components: { StackModal },
    data () {
      return {
        show: false,
        show_second: false,
        show_third: false,
      }
    },
  }
</script>

<style>
    @import "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css";
</style>