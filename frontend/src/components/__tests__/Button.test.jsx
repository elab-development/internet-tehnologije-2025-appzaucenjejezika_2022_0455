import { render, screen } from '@testing-library/react'
import { describe, it, expect } from 'vitest'
import Button from '../Button'

describe('Button', () => {
  it('prikazuje tekst dugmeta', () => {
    render(<Button>Klikni me</Button>)
    expect(screen.getByText('Klikni me')).toBeInTheDocument()
  })

  it('poziva onClick kada se klikne', () => {
    const handleClick = vi.fn()
    render(<Button onClick={handleClick}>Klikni</Button>)
    screen.getByText('Klikni').click()
    expect(handleClick).toHaveBeenCalled()
  })
})