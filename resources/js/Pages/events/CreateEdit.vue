<template>
    <div class="card" :class="event ? 'card-success' : 'card-primary'">
        <div class="card-header">
            <h3 class="card-title">{{ title || 'Create Event' }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form @submit.prevent="submit">
            <div class="card-body">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" :class="{  'is-invalid':  errors.title}" placeholder="Event Title" v-model="form.title" :readonly='readonly' required>
                    <div class="invalid-feedback" v-if="errors.title">{{ errors.title }}</div>
                </div>
                <div class='row'>
                    <div class="form-group col-md-6">
                        <label>Start Date</label>
                        <input type="date" class="form-control" v-model="form.start_date" required :class="{  'is-invalid':  errors.start_date}" :readonly='readonly'>
                        <div class="invalid-feedback" v-if="errors.start_date">{{ errors.start_date }}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>End Date</label>
                        <input type="date" class="form-control" :readonly='readonly' v-model="form.end_date" required :class="{  'is-invalid':  errors.end_date}">
                        <div class="invalid-feedback" v-if="errors.end_date">{{ errors.end_date }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <select class="form-control" v-model="form.location_id" :disabled='readonly'>
                        <option value="">Select Location</option>
                        <option v-for='l of location' :key='l.id' :value='l.id'>
                            {{ l.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class='form-control' v-model="form.description" :readonly='readonly'></textarea>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <template v-if='!readonly'>
                    <button type="submit" class="btn btn-success" v-if='event'>
                        Update
                    </button>
                    <button type="submit" class="btn btn-primary" v-else>
                        Submit
                    </button>
                </template>
                <Link class="btn btn-default" href="/events">
                Back
                </Link>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    props: {
        errors: Object,
        location: Array,
        event: {
            type: Object,
            default: () => null
        },
        title: String,
        readonly: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        let event = this.event || {};
        return {
            was_validated: false,
            form: {
                title: event.title,
                description: event.description,
                location_id: event.location_id || '',
                start_date: event.start_date,
                end_date: event.end_date,
            },
        }
    },
    methods: {
        submit() {
            this.was_validated = true;
            if (this.event) {
                this.$inertia.put(`/events/${this.event.id}`, this.form);
                return;
            }
            this.$inertia.post('/events', this.form)
        },
    },

}

</script>
