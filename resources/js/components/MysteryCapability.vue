<template>
<div>
    <div class="input-field">
        <select id="mystery_data" v-model="mysteryData">
            <option value="" disabled selected>Select Mystery Data</option>
            <option value="MustNotBeHidden">Must not be Hidden</option>
            <option value="MustNotBeKey">Must not be Key</option>
            <option value="MustNotBeHiddenOrKey">Must not be Hidden or Key</option>
            <option value="RequiresAutoSolve">Requires Auto-Solve</option>
        </select>
        <label for="mystery_data">Mystery Data</label>
    </div>
</div>
</template>

<script>
export default {
    data: function() {
        return {
            mysteryData: "",
        }
    },
    mounted() {
        M.FormSelect.init(document.querySelectorAll('select'));
        this.$parent.$on('add_module_capability_fetch_data', (callback) => {
            if(!this.mysteryData) {
                return;
            }

            callback({MysteryModule: this.mysteryData});
        });
    }
}
</script>