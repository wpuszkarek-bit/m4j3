const transactions = [
  { id: 1, user: "Anna", category: "RTV", amount: 1200, status: "completed" },
  { id: 2, user: "Piotr", category: "AGD", amount: 450, status: "pending" },
  { id: 3, user: "Anna", category: "RTV", amount: 300, status: "completed" },
  { id: 4, user: "Jan", category: "AGD", amount: 2100, status: "completed" },
  { id: 5, user: "Piotr", category: "RTV", amount: 150, status: "cancelled" }
];

function analyzeTransactions(data) {
  const summary = data.reduce((acc, { user, category, amount, status }) => {
    if (status !== 'completed') return acc;

    acc.totalCompletedAmount += amount;

    acc.usersSummary[user] = (acc.usersSummary[user] || 0) + amount;

    acc.categoryTotals[category] = (acc.categoryTotals[category] || 0) + amount;

    return acc;
  }, {
    totalCompletedAmount: 0,
    usersSummary: {},
    categoryTotals: {}
  });

  const topCategory = Object.keys(summary.categoryTotals).reduce((a, b) => 
    summary.categoryTotals[a] > summary.categoryTotals[b] ? a : b, ""
  );

  return {
    totalCompletedAmount: summary.totalCompletedAmount,
    usersSummary: summary.usersSummary,
    topCategory: topCategory
  };
}

console.log(analyzeTransactions(transactions));