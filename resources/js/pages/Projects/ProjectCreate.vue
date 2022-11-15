<template>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">Create Project</h6>

        <Errors type="danger" v-if="errors" :content="errors" @close="errors=null"/>

        <form @submit.prevent="createProject">
            <div class="mb-3">
                <label for="workspace" class="form-label">Select Workspace</label>
                <select class="form-select" id="workspace" v-model="form_data.workspace_id" aria-label="Select">
                    <option v-for="workspace in workspaces" :key="workspace.id" :value="workspace.id">
                        {{ workspace.name }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="form_data.name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Select Members</label>
                <select class="form-select" id="workspace" v-model="form_data.members" aria-label="Select" multiple>
                    <option v-for="member in members" :key="member.id" :value="member.id">{{ member.name }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" :disabled="busy"
                    v-text="busy ? 'Loading...' : 'Save'"></button>
        </form>
    </div>
</template>

<script>
import Errors from "@/components/Errors.vue";
import axios from "axios";

export default {
    components: {
        Errors
    },
    data() {
        return {
            form_data: {
                workspace_id: '',
                name: '',
                members: []
            },
            workspaces: [],
            members: [],
            errors: null,
            busy: false,
        }
    },
    mounted() {
        this.getWorkspaces();
        this.getMembers();
    },
    methods: {
        async createProject() {
            this.busy = true;
            this.errors = null

            await axios.post('/api/v1/projects', this.form_data)
                .then(({data}) => {
                    if (data.success === true) {
                        this.$router.push({name: 'projects'})
                    }
                }).catch((err) => {
                    throw err.data
                });

            this.busy = false;
        },
        async getWorkspaces() {
            await axios.get('/api/v1/workspaces').then(({data}) => {
                this.workspaces = data.data
            }).catch((err) => {
                throw err.data
            });
        },
        async getMembers() {
            await axios.get('/api/v1/users').then(({data}) => {
                this.members = data.data
            }).catch((err) => {
                throw err.data
            });
        }
    }
}
</script>

<style scoped>

</style>
