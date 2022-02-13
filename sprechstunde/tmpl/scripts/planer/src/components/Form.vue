<template>

  <div class="si-form">
    <ul class="">
      <li :class="required">
        <label class="text-bold">Titel</label>
        <input type="text"  v-model="form.title" maxlength="20" />
      </li>
      <li :class="required">
        <label>Tag</label>
        <select v-model="form.day">
          <option v-bind:key="j" v-for="(item, j) in showDays" v-if="item == true">{{j}}</option>
        </select>
      </li>
      <li :class="required" >
        <label>Uhrzeit</label>
        <div class="si-clock">
          <select v-model="form.timeHour" class="hours">
            <option v-bind:key="j" v-for="(item, j) in formData.hourCount" >{{formData.hourStart+j}}</option>
          </select>
          <select v-model="form.timeMinute" class="minutes">
            <option>00</option>
            <option>05</option>
            <option>10</option>
            <option>15</option>
            <option>20</option>
            <option>25</option>
            <option>30</option>
            <option>35</option>
            <option>40</option>
            <option>45</option>
            <option>50</option>
            <option>55</option>
          </select>
        </div>
      </li>
      <li :class="required">
        <label>Dauer in Minuten</label>
        <select v-model="form.duration">
          <option>05</option>
          <option>10</option>
          <option>15</option>
          <option>20</option>
          <option>25</option>
          <option>30</option>
          <option>35</option>
          <option>40</option>
          <option>45</option>
          <option>50</option>
          <option>55</option>
          <option>60</option>
        </select>
      </li>

      <li>
        <button @click="submitForm" class="si-btn"><i class="fa fa-save"></i> Speichern</button>
      </li>
    </ul>
  </div>

</template>


<script>

export default {
  name: 'Form',
  props: {
    showDays: Array,
    formData: Array
  },
  data(){
    return {

      error: false,
      required: '',

      form: {
        timeHour: '',
        timeMinute: '',
        title: '',
        day: '',
        duration: ''
      }

    }
  },
  created: function () {
  },

  methods: {

    submitForm: function () {
      var that = this;
      //this.form.date = this.$date(this.form.date).format('YYYY-MM-DD')

      if (!this.form.timeHour
          || !this.form.timeMinute
          || !this.form.title
          || !this.form.day
          || !this.form.duration ) {
        console.log('missing');
        this.required = 'required';
        return false;
      }

      EventBus.$emit('form--submit', {
        form: that.form
      });

    }

  }
}
</script>
