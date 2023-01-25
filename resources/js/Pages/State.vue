<script setup>
import QuarterTable from '@/Components/QuarterTable.vue'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted, computed } from 'vue'

const getQuarterNumber = (date) => {
  const d = new Date(date)
  const month = d.getMonth() + 1
  if(month <= 3) {
    return 1
  } else if(month <= 6) {
    return 2
  } else if(month <= 9) {
    return 3
  } else if(month <= 12) {
    return 4
  }
}

const transformData = (data = []) => {
  const groupByQuarters = []

  for(let i = 0; i < data.length; i++) {
    const row = data[i]
    const d = new Date(row.date)
    const q = getQuarterNumber(d)
    const y = d.getFullYear()
  
    const qIndex = groupByQuarters
      .findIndex((item) => item.quarter === q && item.year === y)
  
    if(qIndex >= 0) {
      const dIndex = groupByQuarters[qIndex].days
        .findIndex((item) => item.date === row.date)
      if(dIndex >= 0) {
        groupByQuarters[qIndex].days[dIndex][row.path]= row.count 
      } else {
        groupByQuarters[qIndex].days.push({
          date: row.date,
          [row.path]: row.count,
        })
      }
    } else {
      groupByQuarters.push({
        quarter: q,
        year: y,
        days: [
          {
            date: row.date,
            [row.path]: row.count,
          }
        ],
      })
    }
  }

  return groupByQuarters
}

const fetchData = () => {
    loading.value = true
    return fetch('http://localhost:8000/client-requests', {
        'content-type': 'application/json',
        method: 'get',
    })
    .then(res => {
        if (!res.ok) {
            const err = new Error(res.statusText)
            err.json = res.json()
            throw err
        }

        return res.json()
    })
    .then(json => {
        data.value = json
    })
    .catch(err => {
        console.log('err', err)
        error.value = err
        if (err.json) {
            return err.json.then(json => {
                error.value.message = json.message
            })
        }
    })
    .then(() => {
        loading.value = false
    })
}

const avg = (items) => {
  const total = items.reduce((acc, c) => acc + c, 0)
  return total / items.length
}

const data = ref({})
const loading = ref(false)
const error = ref(null)

const transformedData = computed(() => {
    return transformData(data.value)
        .map((q) => ({
            ...q,
            dateRange: `${q.days[0].date} - ${q.days[q.days.length - 1].date}`,
            primeAvg: `${avg(q.days.map((d) => d.prime)).toFixed(2)}ms`,
            evenAvg: `${avg(q.days.map((d) => d.even)).toFixed(2)}ms`,
            days: q.days.map((d) => ({
                ...d,
                prime: d.prime > 0 ? `${d.prime}ms` : 'N/A',
                even: d.even > 0 ? `${d.even}ms` : 'N/A'
            })),
        }))
})

onMounted(() => {
    fetchData()
})
</script>
<template>
    <Head title="State" />

    <div class="bg-gray-100 p-4">
        <div
            v-for="(data, index) in transformedData"
            :key="index"
            class="mb-4"
        >
            <QuarterTable :data="data"  /> 
        </div>
    </div>
</template>
