<template>
<div class="modal large" id="maintainerManagerModal">
    <div class="modal-content">
        <h5>Module Maintainer</h5>
        <h6>Add Maintainer</h6>
        <div class="row valign-wrapper">
            <div class="col m10">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="email">
            </div>
            <div class="col m2">
                <button class="btn btn-flat"><i class="material-icons">add</i></button>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="modal-close btn btn-flat">close</button>
    </div>
</div>
</template>

<script>
export default {
    props: ["post_url", "maintainer_string"],
    data: function() {
        return {
            maintainer: [],
            email: "",
        }
    },
    beforeMount() {
        this.maintainer = JSON.parse(this.maintainer_string);
    }
}
</script>