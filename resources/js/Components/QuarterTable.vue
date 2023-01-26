<script setup>
defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
})
</script>

<template>
  <div class="bg-[#fff] p-4">
    <div class="flex mb-2">
      {{ data.dateRange }} (Q{{ data.quarter }})
    </div>
    <div class="flex">
      <strong>
        Summary Data
      </strong>
    </div>
    <table class="table">
      <thead>
          <tr>
            <th scope="col">Metric</th>
            <th scope="col">Prime</th>
            <th scope="col">Even</th>
          </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">Average Request Time</th>
          <td>{{ data.primeAvg }}</td>
          <td>{{ data.evenAvg }}</td>
        </tr>
      </tbody>
    </table>

    <div class="flex mt-4">
      <strong>
        Daily Uptime Details
      </strong>
    </div>
    <table class="table">
      <thead>
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Prime</th>
            <th scope="col">Even</th>
          </tr>
      </thead>
      <tbody>
        <tr v-for="(day, index) in data.days" :key="index">
          <th scope="row">{{ day.date }}</th>
          <td>{{ day.prime }}</td>
          <td>{{ day.even }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
