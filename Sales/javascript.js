async function updateStock(itemID, quantity) {
  const url = "https://inventorysystem.example.org/updateStock";
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ itemID, quantity }),
    });
    if (!response.ok) throw new Error(`Status respons: ${response.status}`);
    const result = await response.json();
    console.log(result);
  } catch (error) {
    console.error(error.message);
  }
}
