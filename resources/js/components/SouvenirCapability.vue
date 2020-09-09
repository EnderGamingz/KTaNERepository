<template>
<div>
    <div class="input-field">
        <select id="souvenir_data" v-model="souvenirData">
            <option value="" disabled selected>Select Souvenir Capability</option>
            <option value="Supported">Supported</option>
            <option value="Unexamined">Unexamined</option>
            <option value="NotACandiate">Not a Canidate</option>
            <option value="Considered">Considered</option>
        </select>
        <label for="souvenir_data">Souvenir Capability</label>
    </div>
</div>
</template>

<script>
export default {
    data: function() {
        return {
            souvenirData: "",
        }
    },
    mounted() {
        M.FormSelect.init(document.querySelectorAll('select'));
    },
    beforeMount() {
        this.$parent.$on('add_module_capability_fetch_data', (callback) => {
            if(!this.souvenirData)
                return;
            
            callback({Souvenir: {Status: this.souvenirData}});
        })
    }
}
</script>