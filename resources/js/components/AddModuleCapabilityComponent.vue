<template>
    <div class="modal large" id="addCapabilityModal">
        <div class="modal-content">
            <h5 class="mt-0">Add Capability</h5>
            <div class="input-field">
                <select id="type" v-model="type">
                    <option value="" disabled selected>Select Capability</option>
                    <option v-for="(cap, index) in capabilityList" :key="index" :value="index">{{ cap }}</option>
                </select>
            </div>
            <div class="mt-4" v-if="type == 'mystery'">
                <mystery-capability></mystery-capability>
            </div>
            <div class="mt-4" v-else-if="type == 'boss'">
                <boss-module-capability></boss-module-capability>
            </div>
            <div class="mt-4" v-else-if="type == 'souvenir'">
                <souvenir-capability></souvenir-capability>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-flat waves-effect" v-on:click="submitData">Add</button>
            <button class="btn modal-close waves-effect btn-flat">Close</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['url', 'raw_capabilities'],
    data: function() {
        return {
            type: "",
            capabilities: [],
            availableCapabilities: {
                mystery: 'Mystery Module Capability',
                boss: 'Boss Module Integration Capability',
                rule_seed: 'Rule Seed Capability',
                souvenir: 'Souvenir Capability',
            }
        }
    },
    beforeMount() {
        this.capabilities = JSON.parse(this.raw_capabilities);
    },
    computed: {
        capabilityList() {
            const newList = Object.entries(this.availableCapabilities).reduce((newlist, [key, val]) => {
                if(!this.capabilities.includes(key)) {
                    this.$set(newlist, key, val);
                }

                return newlist;
            }, {});
            return newList;
        }
    },
    methods: {
        submitData() {
            if(!this.type) {
                return;
            }

            this.$emit("add_module_capability_fetch_data", (data) => {
                axios.post(this.url, {
                    type: this.type,
                    data: JSON.stringify(data)
                }).then((e) => {
                    window.location.href = e.data.redirect_url;
                });
            });
        },
    }
}
</script>