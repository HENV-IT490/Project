import requests
import base64
import os
import random
import sys
import json
#from dotenv import load_dotenv, find_dotenv

api_key = "?apiKey=" + "e0dfc176edf3449794fdc1aa311bc990" # os.getenv("APIKEY")
search_recipies = requests.get("https://api.spoonacular.com/recipes/complexSearch" + str(api_key) + "&query=" + str(sys.argv[1]) + "&instructionsRequired=true&addRecipeInformation=true")
return_json = search_recipies.json()
print(return_json)

#def output(value):
 #   return value
#output(return_json);



search_alternative = "https://api.spoonacular.com/food/ingredients/substitutes"
# ingredient_input = sys.argv[1]
# Example: GET https://api.spoonacular.com/food/ingredients/substitutes?ingredientName=butter

