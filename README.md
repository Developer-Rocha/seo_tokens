# SEO Tokens

## Description

The SEO Tokens module provides custom fields to add SEO descriptions, titles, and images to your content nodes in Drupal. It allows you to set specific fallback fields for each content type, ensuring better optimization for search engines.

## Installation

1. **Download and Extract the Module**:
  - Download the module from the GitHub repository.
  - Extract the files into your site's `modules/custom` directory.

2. **Enable the Module**:
  - Go to your Drupal site's admin interface.
  - Navigate to the **Extend** page (`/admin/modules`).
  - Find the **SEO Tokens** module in the list and check the box next to it.
  - Click the **Install** button at the bottom of the page.

## Configuration

1. **Configure Fallback Fields**:
  - Navigate to the module configuration page at `/admin/config/seo-tokens/settings`.
  - For each content type, you can set fallback fields for **SEO Title**, **SEO Description**, and **SEO Images**.
  - Fallback fields allow you to use existing fields as default values if the custom SEO fields are not filled.

2. **Add SEO Fields to Content Types**:
  - The module automatically adds SEO fields to all content types.
  - You can customize the display of these fields in **Structure > Content types** by editing the **Form Display** and **Display settings** for each content type to include the SEO fields.

## Usage Example

- **SEO Title**: Use the `field_seo_tokens_title` field to set optimized SEO titles for your content nodes.
- **SEO Description**: Use the `field_seo_tokens_description` field to add optimized SEO descriptions to your content nodes.
- **SEO Images**: Use the `field_seo_tokens_image` field to associate optimized SEO images with your content nodes.

## Uninstallation

To uninstall the module:

1. Go to the **Extend** page (`/admin/modules`).
2. Find the **SEO Tokens** module in the list and uncheck the box next to it.
3. Click the **Uninstall** button at the bottom of the page.

**Note**: Uninstalling the module will remove all SEO fields created by the module.

## Contributions

Contributions are welcome! Feel free to submit **pull requests** or open **issues** on the module's GitHub repository.

---
