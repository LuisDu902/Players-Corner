

async function showDeptStatus() {
  const api = '../../api/api_stats.php?' + encodeForAjax({ department: category.textContent, field: 'status' })
  const colors = ["#D66AE6", "#FF5757", "#5271FF", "#FFBD59", "#7ED957"]
  await fetchDataAndGenerateChart(api, '#dept-ticket-status', '#dept-status', colors, 'Tickets by status')
}

async function showDeptPriority() {
  const api = '../../api/api_stats.php?' + encodeForAjax({ department: category.textContent, field: 'priority' })
  const colors = ["#D66AE6", "#FF5757", "#5271FF", "#FFBD59", "#7ED957"]
  await fetchDataAndGenerateChart(api, '#dept-ticket-priority', '#dept-priority', colors, 'Tickets by priority')
}

const deptStats = document.querySelector('#department-stats')
const category = document.querySelector('#department-title')

if (deptStats) {  
  showDeptStatus()
  showDeptPriority()
}

