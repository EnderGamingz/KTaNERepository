<template>
  <div>
    <div class="input-field">
        <select id="rule_data" v-model="ruleData">
            <option value="" disabled selected>Select Rule Seed Support</option>
            <option value="Supported">Supported</option>
            <option value="NotSupported">Not Supported</option>
        </select>
        <label for="rule_data">Rule Seed Support</label>
    </div>
</div>
</template>

<script>
export default {
    data: function () {
        return {
            ruleData: "",
        }
    },
    mounted() {
        M.FormSelect.init(document.querySelectorAll('select'));
    },
    beforeMount() {
        this.$parent.$on('add_module_capability_fetch_data', (callback) => {
            if(!this.ruleData)
                return;
            
            callback({RuleSeedSupport: this.ruleData});
        });
    },
}
</script>