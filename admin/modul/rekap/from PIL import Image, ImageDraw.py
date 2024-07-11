from PIL import Image, ImageDraw

# Create a new image with white background
width, height = 400, 400
image = Image.new('RGB', (width, height), 'white')
draw = ImageDraw.Draw(image)

# Set the coordinates for the first dot
x_start, y_start = 50, 50
dot_radius = 10
spacing = 25

# Draw the dots in the same pattern as the user-provided image
for i in range(3):  # Rows
    for j in range(5):  # Columns for first part of the pattern
        x = x_start + j * spacing
        y = y_start + i * spacing
        draw.ellipse((x - dot_radius, y - dot_radius, x + dot_radius, y + dot_radius), fill='black')

for i in range(5):  # Rows
    for j in range(3):  # Columns for second part of the pattern
        x = x_start + 5 * spacing + j * spacing
        y = y_start + i * spacing
        draw.ellipse((x - dot_radius, y - dot_radius, x + dot_radius, y + dot_radius), fill='black')

# Save the image to a file
image_path = "/mnt/data/dot_pattern_example.png"
image.save(image_path)
image_path
